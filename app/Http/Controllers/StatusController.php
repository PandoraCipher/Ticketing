<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'abreviation' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $status = new Status([
                'name' => $data['name'],
                'abreviation' => $data['abreviation'],
            ]);
            $status->save();
            DB::commit();

            return redirect()->route('setting');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Status $status)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $status = Status::findOrFail($id);

        $status->delete();

        // Redirection avec message de succès
        return redirect()->route('setting')->with('success', 'status deleted successfully');
    }
}
