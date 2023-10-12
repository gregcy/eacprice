<?php

namespace App\Traits;
use App\Models\Tariff;
use App\Models\Adjustment;

trait EACTrait {

    public function calculateEACCost01($consumption, $creditUnits) {
        $dateNow = date('Y-m-d', time());
        $adjustment = Adjustment::where('consumer_type', "Bi-Monthly")
            ->where('start_date', '<=', $dateNow)
            ->where('end_date', '>=', $dateNow)
            ->first();

        $tariff = Tariff::where('code', '01')
            ->where('end_date', '=', null)
            ->first();

        $lowCostConsumption = 0;
        $highCostConsumption = 0;

        if ($consumption >= $creditUnits) {
            $lowCostConsumption = $creditUnits;
            $highCostConsumption = $consumption - $creditUnits;
        }
        else if  ($consumption < $creditUnits) {
            $lowCostConsumption = $consumption;
            $highCostConsumption = 0;
        }

        if ($highCostConsumption > 0) {
            $cost = [
                'energyCharge' => (float) number_format($tariff->energy_charge_normal * $highCostConsumption, 6),
                'networkCharge' => (float) number_format($tariff->network_charge_normal * ($lowCostConsumption + $highCostConsumption), 6),
                'ancilaryServices' => (float) number_format($tariff->ancilary_services_normal * ($lowCostConsumption + $highCostConsumption), 6),
                'publicServiceObligation' => (float) number_format($tariff->public_service_obligation  * ($lowCostConsumption + $highCostConsumption), 6),
                'fuelAdjustment' => (float) number_format($adjustment->revised_fuel_adjustment_price * $highCostConsumption, 6),
                'VAT' => (float) number_format(
                    ($adjustment->revised_fuel_adjustment_price * $highCostConsumption +
                    $tariff->energy_charge_normal * $highCostConsumption +
                    $tariff->network_charge_normal * ($lowCostConsumption + $highCostConsumption) +
                    $tariff->ancilary_services_normal  * ($lowCostConsumption + $highCostConsumption) +
                    $tariff->public_service_obligation * ($lowCostConsumption + $highCostConsumption)) * 0.19, 6
                ),
                'Total' => (float) number_format(
                    ($adjustment->revised_fuel_adjustment_price * $highCostConsumption +
                    $tariff->energy_charge_normal * $highCostConsumption +
                    $tariff->network_charge_normal * ($lowCostConsumption + $highCostConsumption) +
                    $tariff->ancilary_services_normal * ($lowCostConsumption + $highCostConsumption) +
                    $tariff->public_service_obligation *($lowCostConsumption + $highCostConsumption)) * 1.19, 6
                ),
            ];
        }
        else {
            $cost = [
                'networkCharge' => (float) number_format($tariff->network_charge_normal * $lowCostConsumption, 6),
                'ancilaryServices' => (float) number_format($tariff->ancilary_services_normal * $lowCostConsumption, 6),
                'publicServiceObligation' => (float) number_format($tariff->public_service_obligation * $lowCostConsumption, 6),
                'VAT' => (float) number_format(
                    0.19 * ($tariff->network_charge_normal * $lowCostConsumption +
                    $tariff->ancilary_services_normal * $lowCostConsumption +
                    $tariff->public_service_obligation* $lowCostConsumption), 6
                ),
                'Total' => (float) number_format(
                    ($tariff->network_charge_normal * $lowCostConsumption +
                    $tariff->ancilary_services_normal * $lowCostConsumption +
                    $tariff->public_service_obligation *$lowCostConsumption) * 1.19, 6
                ),
            ];
        }
        return $cost;
    }
    public function calculateEACCost02($consumptionNormal, $consumptionReduced) {

        $adjustment = Adjustment::where('consumer_type', "Bi-Monthly")
            ->where('start_date', '<=', $dateNow)
            ->where('end_date', '>=', $dateNow)
            ->first();

        $tariff = Tariff::where('code', '02')
            ->where('end_date', '=', null)
            ->first();

        $time_now = date('H');
        $current_energy_charge = 0;
        $current_network_charge = 0;
        $current_ancilary_services = 0;

        if ($time_now >= 9 && $time_now <= 23) {
            $current_energy_charge = $tariff->energy_charge_normal;
            $current_network_charge = $tariff->network_charge_normal;
            $current_ancilary_services = $tariff->ancilary_services_normal;
        } else {
            $current_energy_charge = $tariff->energy_charge_reduced;
            $current_network_charge = $tariff->network_charge_reduced;
            $current_ancilary_services = $tariff->ancilary_services_reduced;
        }
        $json = [
            'Measurement' => '€/kWh',
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
            'Cost Per Unit' => (float) number_format(
                ($adjustment->revised_fuel_adjustment_price +
                $current_energy_charge +
                $current_network_charge +
                $current_ancilary_services +
                $tariff->public_service_obligation) * 1.19, 6
            ),
        ];
        return $json;
    }
}
