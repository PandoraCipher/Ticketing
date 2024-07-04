<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
            'stdResolutionTime' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            $category = new Category([
                'name' => $data['name'],
                'stdResolutionTime' => $data['stdResolutionTime'],
            ]);
            $category->save();
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
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'stdResolutionTime' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            $category->update([
                'name' => $data['name'],
                'stdResolutionTime' => $data['stdResolutionTime'],
            ]);
            DB::commit();

            return redirect()->route('setting');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->route('setting')->with('success', 'category deleted successfully');
    }
}
