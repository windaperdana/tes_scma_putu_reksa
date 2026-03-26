<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::orderBy('code')->get();
        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:branches|max:50',
            'name' => 'required|max:100',
            'address' => 'nullable',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Branch::create($validated);

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        return view('branches.show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'code' => 'required|max:50|unique:branches,code,' . $branch->id,
            'name' => 'required|max:100',
            'address' => 'nullable',
            'phone' => 'nullable|max:20',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $branch->update($validated);

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Branch deleted successfully.');
    }
}
