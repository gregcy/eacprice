<?php

namespace App\Traits;
use App\Models\Tariff;
use App\Models\Adjustment;

trait EACTrait {

    public function calculateEACCost01($billing, $consumption, $creditUnits) {
        $dateNow = date('Y-m-d', time());
        $adjustment = Adjustment::where('consumer_type', $billing)
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
}
