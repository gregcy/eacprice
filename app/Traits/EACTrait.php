<?php

namespace App\Traits;
use App\Models\Tariff;
use App\Models\Adjustment;

trait EACTrait {

    public function calculateEACCost01($billing, $consmption, $creditUnits) {
        $dateNow = date('Y-m-d', time());
        $adjustment = Adjustment::where('consumer_type', $billing)
            ->where('start_date', '<=', $dateNow)
            ->where('end_date', '>=', $dateNow)
            ->first();

        $tariff = Tariff::where('code', '01')
            ->where('end_date', '=', null)
            ->first();

        if ($creditUnits == 0) {
            $cost = [
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
                'Total' => (float) number_format(
                    ($adjustment->revised_fuel_adjustment_price +
                    $tariff->energy_charge_normal +
                    $tariff->network_charge_normal +
                    $tariff->ancilary_services_normal +
                    $tariff->public_service_obligation) * 1.19, 6
                ),
            ];
        } else {
            $cost = [
                'Network Charge' => (float) number_format($tariff->network_charge_normal, 6),
                'Ancilary Services' => (float) number_format($tariff->ancilary_services_normal, 6),
                'Public Service Obligation' => (float) number_format($tariff->public_service_obligation, 6),
                'VAT' => (float) number_format(
                    0.19 * ($tariff->network_charge_normal +
                    $tariff->ancilary_services_normal +
                    $tariff->public_service_obligation), 6
                ),
                'Total' => (float) number_format(
                    ($tariff->network_charge_normal +
                    $tariff->ancilary_services_normal +
                    $tariff->public_service_obligation) * 1.19, 6
                ),
            ];
        }
        return $cost;
    }
}
