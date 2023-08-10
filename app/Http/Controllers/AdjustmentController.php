<?php

namespace App\Http\Controllers;

use App\Models\Adjustment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view(
            'adjustments.index',
            [
                'adjustments' => Adjustment::with('user')->latest()->paginate(10),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Adjustment::class);

        return view('adjustments.create');
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
                'consumer_type' => 'required',
                'weighted_average_fuel_price' => 'required|numeric',
                'fuel_adjustment_coefficient' => 'required|numeric',
                'voltage_type' => 'required',
                'total' => 'required|numeric',
                'fuel' => 'required|numeric',
                'co2_emissions' => 'required|numeric',
                'cosmos' => 'required|numeric',
                'revised_fuel_adjustment_price' => 'required|numeric',
            ]
        );
        $request->user()->adjustments()->create($validated);
        return redirect(route('adjustments.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Adjustment $adjustment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Adjustment $adjustment): View
    {
        $this->authorize('update', $adjustment);

        return view('adjustments.edit', ['adjustment' => $adjustment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Adjustment $adjustment): RedirectResponse
    {
        $this->authorize('update', $adjustment);

        $validated = $request->validate(
            [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start-date',
                'consumer_type' => 'required',
                'weighted_average_fuel_price' => 'required|numeric',
                'fuel_adjustment_coefficient' => 'required|numeric',
                'voltage_type' => 'required',
                'total' => 'required|numeric',
                'fuel' => 'required|numeric',
                'co2_emissions' => 'required|numeric',
                'cosmos' => 'required|numeric',
            ]
        );

        $adjustment->update($validated);

        return redirect(route('adjustments.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adjustment $adjustment): RedirectResponse
    {
        $this->authorize('delete', $adjustment);

        $adjustment->delete();

        return redirect(route('adjustments.index'));
    }
}
