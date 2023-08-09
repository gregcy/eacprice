<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view(
            'tariffs.index',
            [
                'tariffs' => Tariff::with('user')->latest()->paginate(10),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->authorize('create', Tariff::class);

        return view('tariffs.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after:start-date',
                'code' => 'required',
                'public_service_obligation' => 'nullable|numeric',
                'recurring_supply_charge' => 'nullable|numeric',
                'recurring_meter_reading' => 'nullable|numeric',
                'energy_charge_normal' => 'nullable|numeric',
                'energy_charge_reduced' => 'nullable|numeric',
                'network_charge_normal' => 'nullable|numeric',
                'ancilary_services_normal' => 'nullable|numeric',
                'network_charge_reduced' => 'nullable|numeric',
                'ancilary_services_reduced' => 'nullable|numeric',
                'energy_charge_subsidy_first' => 'nullable|numeric',
                'energy_charge_subsidy_second' => 'nullable|numeric',
                'energy_charge_subsidy_third' => 'nullable|numeric',
                'supply_subsidy_first' => 'nullable|numeric',
                'supply_subsidy_second' => 'nullable|numeric',
                'supply_subsidy_third' => 'nullable|numeric',
            ]
        );
        // Replace nulls with 0's
        $validated = array_map(function($v){
            return (is_null($v)) ? 0 : $v;
        },$validated);
        $request->user()->tariffs()->create($validated);
        return redirect(route('tariffs.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Tariff $Tariff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tariff $Tariff): View
    {
        $this->authorize('update', $Tariff);

        return view('tariffs.edit', ['tariff' => $Tariff]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tariff $Tariff): RedirectResponse
    {
        $this->authorize('update', $Tariff);

        $validated = $request->validate(
            [
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after:start-date',
                'code' => 'required',
                'public_service_obligation' => 'nullable|numeric',
                'recurring_supply_charge' => 'nullable|numeric',
                'recurring_meter_reading' => 'nullable|numeric',
                'energy_charge_normal' => 'nullable|numeric',
                'energy_charge_reduced' => 'nullable|numeric',
                'network_charge_normal' => 'nullable|numeric',
                'ancilary_services_normal' => 'nullable|numeric',
                'network_charge_reduced' => 'nullable|numeric',
                'ancilary_services_reduced' => 'nullable|numeric',
                'energy_charge_subsidy_first' => 'nullable|numeric',
                'energy_charge_subsidy_second' => 'nullable|numeric',
                'energy_charge_subsidy_third' => 'nullable|numeric',
                'supply_subsidy_first' => 'nullable|numeric',
                'supply_subsidy_second' => 'nullable|numeric',
                'supply_subsidy_third' => 'nullable|numeric',
            ]
        );
        // Replace nulls with 0's
        $validated = array_map(function($v){
            return (is_null($v)) ? 0 : $v;
        },$validated);
        $Tariff->update($validated);

        return redirect(route('tariffs.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tariff $Tariff): RedirectResponse
    {
        $this->authorize('delete', $Tariff);

        $Tariff->delete();

        return redirect(route('tariffs.index'));
    }
}