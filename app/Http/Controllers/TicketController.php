<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchTicketsRequest;
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
        $query = Ticket::orderBy('id', 'asc');

        if ($request->input('id') != "") {
            $id = $request->input('id');
            
            $query->where('id', $id);
        }
        if ($request->input('client') != "") {
            $name= $request->input('client');
            
            $query->where('name', $name);
        }
        if ($request->input('assigned') != "") {
            $assigned= $request->input('assigned');
            
            $query->where('assigned', $assigned);
        }
        if ($request->input('status') != "") {
            $status = $request->input('status');
            
            $query->where('status', $status);
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
            'priority' => 'required|string',
            'subject' => 'required|string',
            'assigned' => 'required|string',
            'description' => 'required|string',
            'file' => 'file|mimes:pdf,docx,png,jpg,xlsx,xls|max:10240',
        ]);

        $ticket = new Ticket([
            'name' => $data['name'],
            'subject' => $data['subject'],
            'priority' => $data['priority'],
            'assigned' => $data['assigned'],
            'status' => 'Open',
            'description' => $data['description'],
        ]);
        if ($request->hasFile('file')) {
            // Enregistrer le fichier dans le dossier de stockage public/files
            $filePath = $request->file('file')->store('public/files');

            // Sauvegarder le chemin du fichier dans l'instance du ticket
            $ticket->file = $filePath;
        }

        // Enregistrer le ticket dans la base de données
        $ticket->save();
        return redirect()->route('tickets.list');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $users = User::all();
        return view('tickets.show', compact('ticket', 'users'));
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
            'name' => 'required|string',
            'priority' => 'required|string',
            'subject' => 'required|string',
            'assigned' => 'required|string',
            'status' => 'required|string',
            'description' => 'required|string',
            'file' => 'file|mimes:pdf,docx,png,jpg,xlsx,xls|max:10240', //Validation du fichier (exemple: PDF, DOCX, taille maximale 2048 Ko)
        ]);

        $ticket->update([
            'name' => $data['name'],
            'priority' => $data['priority'],
            'subject' => $data['subject'],
            'assigned' => $data['assigned'],
            'status' => $data['status'],
            'description' => $data['description'],
        ]);
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('public/files');
            $ticket->file = $filePath;
        }
        $ticket->save();
        return redirect()->route('tickets.list');
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
