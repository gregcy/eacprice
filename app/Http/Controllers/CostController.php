<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * EAC Extra Cost Controller
 * {@inheritdoc}
 */
class CostController extends Controller
{
    /**
     * Display a listing of all extra costs.
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
     * Show the form for creating a new extra cost.
     */
    public function create(): View
    {
        $this->authorize('create', Cost::class);

        return view('costs.create');
    }

    /**
     * Store a newly created extra cost in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after:start-date',
                'name' => 'string',
                'prefix' => 'nullable|string',
                'suffix' => 'nullable|string',
                'code' => 'nullable|string',
                'value' => 'required|numeric',
                'source' => 'nullable|url',
                'source_name' => 'nullable|string',
            ]
        );
        $request->user()->costs()->create($validated);

        return redirect(route('costs.index'));
    }

    /**
     * Display the specified extra cost.
     */
    public function show(Cost $cost)
    {
        //
    }

    /**
     * Show the form for editing th extra cost
     */
    public function edit(Cost $cost): View
    {
        $this->authorize('update', $cost);

        return view('costs.edit', ['cost' => $cost]);
    }

    /**
     * Update the specified extra cost in storage.
     */
    public function update(Request $request, Cost $cost): RedirectResponse
    {
        $this->authorize('update', $cost);

        $validated = $request->validate(
            [
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after:start-date',
                'name' => 'string',
                'prefix' => 'nullable|string',
                'suffix' => 'nullable|string',
                'code' => 'nullable|string',
                'value' => 'required|numeric',
                'source' => 'nullable|url',
                'source_name' => 'nullable|string',
            ]
        );

        $cost->update($validated);

        return redirect(route('costs.index'));
    }

    /**
     * Remove the specified extra cost from storage.
     */
    public function destroy(Cost $cost): RedirectResponse
    {
        $this->authorize('delete', $cost);

        $cost->delete();

        return redirect(route('costs.index'));
    }
}
