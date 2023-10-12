<?php

namespace App\Http\Controllers;

use App\Models\Adjustment;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Traits\EACTrait;

class GetCurrentRate extends Controller
{
    use EACTrait;

    public function calculator(): View
    {
        return view('rate.calculator');
    }

    public function calculate(Request $request): View
    {
        $validated = $request->validate(
            [
                'consumption' => 'nullable|numeric|gte:0',
                'credit-amount' => 'nullable|numeric|gte:0',
                'consumption-standard' => 'nullable|numeric|gte:0',
                'consumption-economy' => 'nullable|numeric|gte:0',
            ]
        );

        return view(
            'rate.calculate',
            [

            ]
        );
    }
    public function index(Request $request)
    {
        $json = '';

        try {
            $request->validate(
                [
                    'tariffCode' => [Rule::in(['01', '02', '08'])],
                    'unitsConsumed' => 'numeric|gte:0',
                    'creditUnits' => 'boolean',
                ]
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
        $tariffCode = request('tariffCode', '01');
        $billing = request('billing', 'Bi-Monthly');
        $unitsConsumed = request('unitsConsumed', 1);
        $creditUnits = request('creditUnits', 0);

        if ($tariffCode == '01') {
            if (!$creditUnits) {
                $consumption = $this->calculateEACCost01(1, 0);

            }
            else {
                $consumption = $this->calculateEACCost01(1, 2);
            }
        }
        if ($tariffCode == '02') {

        }
        $json = ['Measurement' => '€/kWh', 'Cost' => $consumption];

        // } elseif ($tariffCode == '02') {

        //
        // } elseif ($tariffCode == '08') {

        //     $current_energy_charge = 0;

        //     if ($unitsConsumed <= 1000) {
        //         $current_energy_charge = $tariff->energy_charge_subsidy_first;
        //     } elseif ($unitsConsumed > 1000 && $unitsConsumed <= 2000) {
        //         $current_energy_charge = $tariff->energy_charge_subsidy_second;
        //     } elseif ($unitsConsumed > 2000) {
        //         $current_energy_charge = $tariff->energy_charge_subsidy_third;
        //     }

        //     $json = [
        //         'Measurement' => '€/kWh',
        //         'Breakdown' => [
        //             'Energy Charge' => (float) number_format($current_energy_charge, 6),
        //             'Fuel Adjustment' => (float) number_format($adjustment->revised_fuel_adjustment_price, 6),
        //             'VAT' => (float) number_format(
        //                 0.19 * ($adjustment->revised_fuel_adjustment_price +
        //                 $current_energy_charge), 6
        //             ),
        //         ],
        //         'Cost Per Unit' => (float) number_format(
        //             ($adjustment->revised_fuel_adjustment_price +
        //             $current_energy_charge) * 1.19, 6
        //         ),
        //     ];
        // }

        return response()->json(
            $json, 200
        );
    }
}
