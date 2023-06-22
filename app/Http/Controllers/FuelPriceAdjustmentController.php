<?php

namespace App\Http\Controllers;

use App\Models\FuelPriceAdjustment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FuelPriceAdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        return view('fuel-price-adjustment.index');
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
        //
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
