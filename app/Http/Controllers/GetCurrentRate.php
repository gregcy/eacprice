<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adjustment;
use App\Models\Tariff;
use Illuminate\Validation\Rule;

class GetCurrentRate extends Controller
{
    public function index(Request $request)
    {
        $json = '';

        try {
            $validated = $request->validate(
                [
                    'tariffCode' => [Rule::in(["01", "02", "08"])],
                    'billing' => [Rule::in(["Monthly", "Bi-Monthly"])],
                    'unitsConsumed' => 'numeric',
                    'creditUnits' => 'boolean',
                ]
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
        $tariffCode = request('tariffCode', '01');
        $billing = request('billing', 'Bi-Monthly');
        $unitsConsumed = request('unitsConsumed', 0);
        $creditUnits = request('creditUnits', false);

        $dateNow = date('Y-m-d', time());
        $adjustment = Adjustment::where('consumer_type', $billing)
            ->where('start_date', '<=', $dateNow)
            ->where('end_date', '>=', $dateNow)
            ->first();
        $tariff = Tariff::where('code', $tariffCode)
            ->where('end_date', '=', 0)
            ->first();


        if ($tariffCode == '01') {
            if ($creditUnits == "0") {
                $json = [
                    'Measurement' => '€/kWh',
                    'Cost Per Unit' => (float) number_format(
                        ($adjustment->revised_fuel_adjustment_price +
                        $tariff->energy_charge_normal +
                        $tariff->network_charge_normal +
                        $tariff->ancilary_services_normal +
                        $tariff->public_service_obligation)*1.19, 6
                    ),
                    'Breakdown' => [
                        'Energy Charge' => (float) number_format($tariff->energy_charge_normal, 6),
                        'Network Charge' => (float) number_format($tariff->network_charge_normal, 6),
                        'Ancilary Services' => (float) number_format($tariff->ancilary_services_normal, 6),
                        'Public Service Obligation' => (float) number_format($tariff->public_service_obligation, 6),
                        'Fuel Adjustment' => (float) number_format($adjustment->revised_fuel_adjustment_price, 6),
                        'VAT' => (float) number_format(
                            0.19 * ($adjustment->revised_fuel_adjustment_price +
                            $tariff->energy_charge_normal +
                            $tariff->network_charge_normal +
                            $tariff->ancilary_services_normal +
                            $tariff->public_service_obligation), 6
                        ),
                    ],
                ];
            }
            else {
                $json = [
                    'Measurement' => '€/kWh',
                    'Cost Per Unit' => (float) number_format(
                        ($tariff->network_charge_normal +
                        $tariff->ancilary_services_normal +
                        $tariff->public_service_obligation)*1.19, 6
                    ),
                    'Breakdown' => [
                        'Network Charge' => (float) number_format($tariff->network_charge_normal, 6),
                        'Ancilary Services' => (float) number_format($tariff->ancilary_services_normal, 6),
                        'Public Service Obligation' => (float) number_format($tariff->public_service_obligation, 6),
                        'VAT' => (float) number_format(
                            0.19*($tariff->network_charge_normal +
                            $tariff->ancilary_services_normal +
                            $tariff->public_service_obligation), 6
                        ),
                    ]
                ];
            }
        }

        else if ($tariffCode == '02') {

            $time_now = date('H');
            $current_energy_charge = 0;
            $current_network_charge = 0;
            $current_ancilary_services = 0;

            if ($time_now >= 9 && $time_now <= 23) {
                $current_energy_charge = $tariff->energy_charge_normal;
                $current_network_charge = $tariff->network_charge_normal;
                $current_ancilary_services = $tariff->ancilary_services_normal;
            }
            else {
                $current_energy_charge = $tariff->energy_charge_reduced;
                $current_network_charge = $tariff->network_charge_reduced;
                $current_ancilary_services = $tariff->ancilary_services_reduced;
            }

            if ($creditUnits == "0") {
                $json = [
                    'Measurement' => '€/kWh',
                    'Cost Per Unit' => (float) number_format(
                        ($adjustment->revised_fuel_adjustment_price +
                        $current_energy_charge +
                        $current_network_charge +
                        $current_ancilary_services +
                        $tariff->public_service_obligation)*1.19, 6
                    ),
                    'Breakdown' => [
                        'Energy Charge' => (float) number_format($current_energy_charge, 6),
                        'Network Charge' => (float) number_format($current_network_charge, 6),
                        'Ancilary Services' => (float) number_format($current_ancilary_services, 6),
                        'Public Service Obligation' => (float) number_format($tariff->public_service_obligation, 6),
                        'Fuel Adjustment' => (float) number_format($adjustment->revised_fuel_adjustment_price, 6),
                        'VAT' => (float) number_format(
                            0.19 * ($adjustment->revised_fuel_adjustment_price +
                            $current_energy_charge +
                            $current_network_charge +
                            $current_ancilary_services +
                            $tariff->public_service_obligation), 6
                        ),
                    ],
                ];
            }
            else {
                $json = [
                    'Measurement' => '€/kWh',
                    'Cost Per Unit' => (float) number_format(
                        ($current_energy_charge +
                        $current_network_charge +
                        $tariff->public_service_obligation)*1.19, 6
                    ),
                    'Breakdown' => [
                        'Network Charge' => (float) number_format($current_network_charge, 6),
                        'Ancilary Services' => (float) number_format($current_ancilary_services, 6),
                        'Public Service Obligation' => (float) number_format($tariff->public_service_obligation, 6),
                        'VAT' => (float) number_format(
                            0.19*($current_energy_charge +
                            $current_network_charge +
                            $tariff->public_service_obligation), 6
                        ),
                    ]
                ];
            }

        }
        else if ($tariffCode == '08') {

        }

        return response()->json(
           $json, 200
        );
    }
}
