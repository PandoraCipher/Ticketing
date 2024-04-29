<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchTicketsRequest;
use App\Models\Note;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if ($user->role == "User"){
            $query->where(function ($query) use ($user) {
                $query->where('name', $user->name)
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

            $query->where('client', $client);
        }
        if ($request->input('assigned') != '') {
            $assigned = $request->input('assigned');

            $query->where('assigned', $assigned);
        }
        if ($request->input('status') != '') {
            $status = $request->input('status');
            if ($status == 'Open' || $status == 'AAR' || $status == 'ACR') {
                $query->whereIn('status', ['Open', 'AAR', 'ACR']);
            } else {
                $query->where('status', $status);
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

        $tickets = $query->paginate(10);
        $input = $request->validated();

        return view('tickets.list', compact('tickets', 'input'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ticket = new Ticket();
        $users = User::all();
        return view('tickets.create', ['ticket' => $ticket], ['users' => $users]);
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
            'file' => 'file|mimes:pdf,docx,png,jpg,xlsx,xls|max:10240',
        ]);

        $ticket = new Ticket([
            'name' => $data['name'],
            'client' => $data['client'],
            'subject' => $data['subject'],
            'priority' => $data['priority'],
            'assigned' => $data['assigned'],
            'status' => 'Open',
        ]);
        if ($request->hasFile('file')) {
            // Enregistrer le fichier dans le dossier de stockage public/files
            $filePath = $request->file('file')->store('public/files');

            // Sauvegarder le chemin du fichier dans l'instance du ticket
            $ticket->file = $filePath;
        }

        // Enregistrer le ticket dans la base de données
        $ticket->save();

        $note = new Note();
        $note->ticket_id = $ticket->id;
        $note->author = $request->user()->name;
        $note->assigned = $data['assigned'];
        $note->content = $data['note'];
        $note->status = 'Open';
        $note->save();
        return redirect()->route('tickets.list');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $users = User::all();
        $notes = Note::where('ticket_id', $ticket->id)->get();
        return view('tickets.show', compact('ticket', 'users', 'notes'));
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
        $data = $request->validate([
            // 'name' => 'required|string',
            // 'client' => 'required|string',
            'priority' => 'required|string',
            'subject' => 'required|string',
            'note' => 'required|string',
            'assigned' => 'required|string',
            'status' => 'required|string',
            'file' => 'file|mimes:pdf,docx,png,jpg,xlsx,xls|max:10240', //Validation du fichier (exemple: PDF, DOCX, taille maximale 2048 Ko)
        ]);

        $ticket->update([
            // 'name' => $data['name'],
            // 'client' => $data['client'],
            'priority' => $data['priority'],
            'subject' => $data['subject'],
            'assigned' => $data['assigned'],
            'status' => $data['status'],
        ]);
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('public/files');
            $ticket->file = $filePath;
        }
        $ticket->save();

        $note = new Note();
        $note->ticket_id = $ticket->id;
        $note->author = $request->user()->name;
        $note->assigned = $data['assigned'];
        $note->content = $data['note'];
        $note->status = $data['status'];
        $note->save();

        return redirect()->route('tickets.show', $ticket->id);
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
        // Récupérer le chemin complet du fichier
        $filePath = storage_path('app/public/files/' . $filename);

        // Vérifier si le fichier existe
        if (!Storage::exists('public/files/' . $filename)) {
            abort(404);
        }

        // Télécharger le fichier en utilisant le nom original
        return response()->download($filePath, $filename);
    }
}
