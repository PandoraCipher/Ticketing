<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::latest()->get();
        //dd($tickets);
        return view('tickets.list', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ticket = new Ticket();
        return view('tickets.create', ['ticket' => $ticket]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ticket::create([
        //     'name' => request('name'),
        //     'priority' => request('priority'),
        //     'assigned' => request('assigned'),
        //     'status' => request('status'),
        //     'description' => request('description'),
        // ]);
        $data = $request->validate([
            'name' => 'required|string',
            'priority' => 'required|string',
            'assigned' => 'required|string',
            'description' => 'required|string',
            'file' => 'file|mimes:pdf,docx|max:2048',
        ]);
    
        Ticket::create([
            'name' => $data['name'],
            'priority' => $data['priority'],
            'assigned' => $data['assigned'],
            'status' => 'Open',
            'description' => $data['description'],
            'file' => $data['file'] ?? null,
        ]);
        return redirect()->route('tickets.list');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('tickets.show', compact('ticket'));
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
            'assigned' => 'required|string',
            'status' => 'required|string',
            'description' => 'required|string',
            // 'file' => 'file|mimes:pdf,docx|max:2048',  Validation du fichier (exemple: PDF, DOCX, taille maximale 2048 Ko)
        ]);

        $ticket->update([
            'name' => $data['name'],
            'priority' => $data['priority'],
            'assigned' => $data['assigned'],
            'status' => $data['status'],
            'description' => $data['description'],
        ]);
        // if ($request->hasFile('file')) {
        //     $filePath = $request->file('file')->store('tickets/files');
        //     $ticket->file = $filePath;
            
        // }
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
}
