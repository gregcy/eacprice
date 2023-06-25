<?php

namespace App\Http\Controllers;

use App\Models\FuelPriceAdjustment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FuelPriceAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        return view(
            'fuel-price-adjustment.index',
            [
                'fuelAdjustments' => FuelPriceAdjustment::with('user')->latest()->paginate(10),
            ]
        );
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
            ]
        );
        $request->user()->fuelPriceAdjustments()->create($validated);
        return redirect('/adjustments');
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelPriceAdjustment $fuelPriceAdjustment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FuelPriceAdjustment $fuelPriceAdjustment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FuelPriceAdjustment $fuelPriceAdjustment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuelPriceAdjustment $fuelPriceAdjustment)
    {
        //
    }
}
