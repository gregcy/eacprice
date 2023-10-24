<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view(
            'costs.index',
            [
                'costs' => Cost::with('user')->latest()->paginate(10),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Cost::class);

        return view('costs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start-date',
                'name' => 'string',
                'prefix' => 'nullable|string',
                'suffix' => 'nullable|string',
                'value' => 'required|numeric',
                'source' => 'nullable|url'
            ]
        );
        $request->user()->costs()->create($validated);

        return redirect(route('costs.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cost $cost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cost $cost): View
    {
        $this->authorize('update', $cost);

        return view('costs.edit', ['cost' => $cost]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cost $cost): RedirectResponse
    {
        $this->authorize('update', $cost);

        $validated = $request->validate(
            [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start-date',
                'name' => 'string',
                'prefix' => 'nullable|string',
                'suffix' => 'nullable|string',
                'value' => 'required|numeric',
                'source' => 'nullable|url'
            ]
        );

        $cost->update($validated);

        return redirect(route('costs.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cost $cost): RedirectResponse
    {
        $this->authorize('delete', $cost);

        $cost->delete();

        return redirect(route('costs.index'));
    }
}
