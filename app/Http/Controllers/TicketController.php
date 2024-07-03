<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchTicketsRequest;
use App\Events\TicketCreated;
use App\Events\TicketUpdated;
use App\Models\Category;
use App\Models\Intervention;
use App\Models\Note;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchTicketsRequest $request)
    {
        $user = Auth::user();
        $query = Ticket::orderBy('id', 'desc');

        if ($user->role == 'User') {
            $query->where(function ($query) use ($user) {
                $query
                    ->where('name', $user->name)
                    ->orWhere('client', $user->name)
                    ->orWhere('assigned', $user->name);
            });
        }

        if ($request->input('id') != '') {
            $id = $request->input('id');

            $query->where('id', $id);
        }
        if ($request->input('client') != '') {
            $client = $request->input('client');

            $query->where('client', 'like', "%$client%");
        }
        if ($request->input('assigned') != '') {
            $assigned = $request->input('assigned');

            $query->where('assigned', 'like', "%$assigned%");
        }
        if ($request->input('status') != '') {
            $status = $request->input('status');
            if ($status == 'Open') {
                $query->where('status', 'Open');
            } elseif ($status == 'Closed') {
                $query->where('status', 'Closed');
            } elseif ($status == 'Pending') {
                $query->whereNotIn('status', ['Open', 'Closed']);
            }
        }

        if ($request->input('begin') != '') {
            $begin = $request->input('begin');

            $query->whereDate('created_at', '>=', $begin);
        }
        if ($request->input('end') != '') {
            $end = $request->input('end');

            $query->whereDate('created_at', '<=', $end);
        }
        if ($request->input('update') != '') {
            $update = $request->input('update');

            $query->whereDate('updated_at', '>=', $update);
        }

        $tickets = $query->paginate(10);
        $input = $request->validated();

        return view('tickets.list', compact('tickets', 'input'));
    }

    /**
     * function to show open and pending tickets on the dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        $openTicketsCount = 0;
        $pendingTicketsCount = 0;
        $myTicketsCount = 0;
        $tickets = [];
        $adminOpenTicketsCounts = [];
        $adminPendingTicketsCounts = [];

        if (Ticket::count() > 0) {
            $query = Ticket::orderBy('id', 'desc')->whereDate('created_at', '=', now()->toDateString());
            $myTicketsCount = Ticket::where('assigned', $user->name)
                ->whereIn('status', ['Open', 'AAR', 'ACR'])
                ->count();

            if ($user->role == 'User') {
                $query->where(function ($query) use ($user) {
                    $query
                        ->where('name', $user->name)
                        ->orWhere('client', $user->name)
                        ->orWhere('assigned', $user->name);
                });
            }

            // Compter les tickets ouverts liés à l'utilisateur connecté
            if ($user->role == 'User') {
                $openTicketsCount = Ticket::where('status', 'Open')
                    ->where(function ($query) use ($user) {
                        $query
                            ->where('name', $user->name)
                            ->orWhere('client', $user->name)
                            ->orWhere('assigned', $user->name);
                    })
                    ->count();
            } else {
                // Compter tous les tickets ouverts
                $openTicketsCount = Ticket::where('status', 'Open')->count();
            }

            // Compter les tickets en attente en fonction du rôle de l'utilisateur
            if ($user->role == 'User') {
                $pendingTicketsCount = Ticket::where(function ($query) use ($user) {
                    $query
                        ->where('name', $user->name)
                        ->orWhere('client', $user->name)
                        ->orWhere('assigned', $user->name);
                })
                    ->whereIn('status', ['AAR', 'ACR'])
                    ->count();
            } else {
                // Si l'utilisateur n'est pas un simple utilisateur, comptez tous les tickets en attente
                $pendingTicketsCount = Ticket::whereIn('status', ['AAR', 'ACR'])->count();
            }

            $adminUsers = User::where('role', 'Admin')->get();
            foreach ($adminUsers as $adminUser) {
                $adminOpenTicketsCount = Ticket::where('assigned', $adminUser->name)
                    ->where('status', 'Open')
                    ->count();

                $adminPendingTicketsCount = Ticket::where('assigned', $adminUser->name)
                    ->whereIn('status', ['AAR', 'ACR'])
                    ->count();

                // Stocker les résultats dans un tableau associatif avec le nom de l'utilisateur comme clé
                $adminOpenTicketsCounts[$adminUser->name] = $adminOpenTicketsCount;
                $adminPendingTicketsCounts[$adminUser->name] = $adminPendingTicketsCount;
            }

            $tickets = $query->paginate(5);
        }

        return view('dashboard', compact(['openTicketsCount', 'pendingTicketsCount', 'myTicketsCount', 'adminOpenTicketsCounts', 'adminPendingTicketsCounts', 'tickets']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ticket = new Ticket();
        $users = User::all();
        $categories = Category::get();
        return view('tickets.create', ['ticket' => $ticket, 'users' => $users, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'client' => 'required|string',
            'priority' => 'required|string',
            'subject' => 'required|string',
            'note' => 'required|string',
            'assigned' => 'required|string',
            'category' => 'required|string',
            'file' => 'file|mimes:pdf,docx,png,jpg,jpeg,xlsx,xls,msg|max:10240',
            'start_incident' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        DB::beginTransaction();
        $category = Category::findOrFail($data['category']);

        try {
            $ticket = new Ticket([
                'name' => $data['name'],
                'client' => $data['client'],
                'subject' => $data['subject'],
                'priority' => $data['priority'],
                'assigned' => $data['assigned'],
                'category' => $category->name,
                'status' => 'Open',
            ]);

            $ticket->save();

            $intervention = new Intervention();
            $intervention->start_incident = isset($data['start_incident']) ? Carbon::createFromFormat('Y-m-d\TH:i', $data['start_incident'])->toDateTimeString() : null;
            $intervention->category_id = $data['category'];
            $intervention->ticket_id = $ticket->id;
            $intervention->save();

            $ticket->intervention()->associate($intervention)->save();

            $note = new Note();
            $note->ticket_id = $ticket->id;
            $note->author = $request->user()->name;
            $note->assigned = $data['assigned'];
            $note->content = $data['note'];
            $note->status = 'Open';

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store();
                $note->file = $filePath;
            }
            $note->save();

            DB::commit();
            //event(new TicketCreated($ticket));
            return redirect()->route('tickets.list');
            //echo json_encode($intervention, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()]);
        } catch (RequestException $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withErrors(['error' => 'Request timeout. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $users = User::orderBy('name', 'asc')->get();
        $notes = Note::where('ticket_id', $ticket->id)->get();
        $statuses = Status::get();
        return view('tickets.show', compact('ticket', 'users', 'notes', 'statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        $data = $request->validate([
            'priority' => 'required|string',
            'note' => 'required|string',
            'assigned' => 'required|string',
            'status' => 'required|string',
            'file' => 'file|mimes:pdf,docx,png,jpg,jpeg,xlsx,xls,msg|max:10240',
            'start_incident' => 'nullable|date_format:Y-m-d\TH:i',
            'start_operation' => 'nullable|date_format:Y-m-d\TH:i',
            'end_operation' => 'nullable|date_format:Y-m-d\TH:i',
            'restore_date' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        $status = $user->role == 'User' ? 'AAR' : $data['status'];

        DB::beginTransaction();

        try {
            $ticket->update([
                'priority' => $data['priority'],
                'assigned' => $data['assigned'],
                'status' => $status,
            ]);

            $intervention = $ticket->intervention;
            if (!$intervention) {
                $intervention = new Intervention(['ticket_id' => $ticket->id]);
            }
            $durationInSeconds = 0;
            if (!empty($data['start_operation'])) {
                $startOperationTimestamp = strtotime($data['start_operation']);
                if (!empty($data['end_operation'])) {
                    $endOperationTimestamp = strtotime($data['end_operation']);
                    $durationInSeconds = abs($endOperationTimestamp - $startOperationTimestamp);
                }
            }
            $downtimeDurationInSeconds = 0;
            if (!empty($data['start_incident'])) {
                $startIncidentTimestamp = strtotime($data['start_incident']);
                if (!empty($data['restore_date'])) {
                    $restoreDateTimestamp = strtotime($data['restore_date']);
                    $downtimeDurationInSeconds = abs($restoreDateTimestamp - $startIncidentTimestamp);
                }
            }

            $interventionDurationMinutes = $durationInSeconds / 60;
            $DowntimeResolutionMinutes = $downtimeDurationInSeconds / 60;

            $intervention->update([
                'start_incident' => isset($data['start_incident']) ? Carbon::createFromFormat('Y-m-d\TH:i', $data['start_incident'])->toDateTimeString() : null,
                'start_interv' => isset($data['start_operation']) ? Carbon::createFromFormat('Y-m-d\TH:i', $data['start_operation'])->toDateTimeString() : null,
                'end_interv' => isset($data['end_operation']) ? Carbon::createFromFormat('Y-m-d\TH:i', $data['end_operation'])->toDateTimeString() : null,
                'restore_date' => isset($data['restore_date']) ? Carbon::createFromFormat('Y-m-d\TH:i', $data['restore_date'])->toDateTimeString() : null,
                'intervention_duration' => $interventionDurationMinutes,
                'downtime_resolution' => $DowntimeResolutionMinutes,
            ]);

            $note = new Note();
            $note->ticket_id = $ticket->id;
            $note->author = $request->user()->name;
            $note->assigned = $data['assigned'];
            $note->content = $data['note'];
            $note->status = $status;

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store();
                $note->file = $filePath;
            }

            $note->save();
            DB::commit();
            //event(new TicketUpdated($ticket));

            return redirect()
                ->route('tickets.show', $ticket->id)
                ->with('message', 'Ticket updated successfully.');
            // echo json_encode($data, JSON_PRETTY_PRINT);
            // echo json_encode($intervention, JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withErrors(['error' => $e->getMessage()]);
        } catch (RequestException $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->withErrors(['error' => 'Request timeout. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function download($filename)
    {
        $decodedFilename = urldecode($filename);
        $path = storage_path('app/' . $decodedFilename);

        if (file_exists($path)) {
            return response()->download($path);
        } else {
            return redirect()->back()->with('error', 'Fichier non trouvé');
        }
    }

    public function exportPDF($ticketId)
    {
        $ticket = Ticket::with(['intervention', 'notes'])->find($ticketId);
        $user = User::where('name',$ticket->client)->first();

        $data = [
            'ticket' => $ticket,
            'user' => $user,
            'intervention' => $ticket->intervention,
            'notes' => $ticket->notes,
        ];
        $pdf = Pdf::loadView('intervention.interventionDoc', $data);
        //return $pdf->download('ticket_' . $ticketId . '.pdf');
        echo json_encode(([$user]), JSON_PRETTY_PRINT);
    }
}
