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

        $fullPricedConsumption = $consumption - $creditUnits;
        $lowPricedConsumption = 0;
        if ($creditUnits > 0) {
            if ($consumption > $creditUnits) {
                $lowPricedConsumption = $creditUnits;
            } else {
                $lowPricedConsumption = $consumption;
            }
        }

        if ( ($lowPricedConsumption < $fullPricedConsumption) && ($lowPricedConsumption > 0)) {
            $cost = [
                'energyCharge' => (float) number_format($tariff->energy_charge_normal * $fullPricedConsumption, 6),
                'networkCharge' => (float) number_format($tariff->network_charge_normal * $lowPricedConsumption , 6),
                'ancilaryServices' => (float) number_format($tariff->ancilary_services_normal * $lowPricedConsumption, 6),
                'publicServiceObligation' => (float) number_format($tariff->public_service_obligation  * $lowPricedConsumption, 6),
                'fuelAdjustment' => (float) number_format($adjustment->revised_fuel_adjustment_price * $fullPricedConsumption, 6),
                'VAT' => (float) number_format(
                    0.19 * ($adjustment->revised_fuel_adjustment_price * $fullPricedConsumption +
                    $tariff->energy_charge_normal * $fullPricedConsumption +
                    $tariff->network_charge_normal * $lowPricedConsumption +
                    $tariff->ancilary_services_normal  * $lowPricedConsumption+
                    $tariff->public_service_obligation * $lowPricedConsumption), 6
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
                'networkCharge' => (float) number_format($tariff->network_charge_normal, 6),
                'ancilaryServices' => (float) number_format($tariff->ancilary_services_normal, 6),
                'publicServiceObligation' => (float) number_format($tariff->public_service_obligation, 6),
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
