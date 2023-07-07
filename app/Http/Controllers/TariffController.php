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
                'end_date' => 'required|date|after:start-date',
                'code' => 'required',
                'public_service_obligation' => 'required|numeric',
                'recurring_supply_charge' => 'required|numeric',
                'recurring_meter_reading' => 'required|numeric',
                'energy_charge_normal' => 'required|numeric',
                'energy_charge_reduced' => 'required|numeric',
                'network_charge_normal' => 'required|numeric',
                'ancilary_services_normal' => 'required|numeric',
                'network_charge_reduced' => 'required|numeric',
                'ancilary_services_reduced' => 'required|numeric',
                'consumption_from' => 'numeric',
                'consumption_to' => 'numeric',
            ]
        );
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
                'end_date' => 'required|date|after:start-date',
                'code' => 'required',
                'public_service_obligation' => 'required|numeric',
                'recurring_supply_charge' => 'required|numeric',
                'recurring_meter_reading' => 'required|numeric',
                'energy_charge_normal' => 'required|numeric',
                'energy_charge_reduced' => 'required|numeric',
                'network_charge_normal' => 'required|numeric',
                'ancilary_services_normal' => 'required|numeric',
                'network_charge_reduced' => 'required|numeric',
                'ancilary_services_reduced' => 'required|numeric',
                'consumption_from' => 'nullable|numeric',
                'consumption_to' => 'nullable|numeric',
            ]
        );

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
