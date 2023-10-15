<?php

/**
 * Path: app/Traits/EACTrait.php
 * Compare this snippet from app/Http/Controllers/GetCurrentRate.php:
 *
 * @author  Greg Andreou <greg.andreou@gmail.com>
 * @license  MIT
 *
 */

namespace App\Traits;
use App\Models\Tariff;
use App\Models\Adjustment;
use DateTime;

trait EACTrait {

    public function calculateEACCost01(int $consumption, int $creditUnits, DateTime $periodStart, DateTime $periodEnd): array
    {
        $adjustment = Adjustment::where('consumer_type', "Bi-Monthly")
            ->where('start_date', '<=', $periodStart)
            ->where('end_date', '>=', $periodEnd)
            ->first();

        $tariff = Tariff::where('code', '01')
            ->where('end_date', '=', null)
            ->first();

        $lowCostConsumption = 0;
        $highCostConsumption = 0;

        if ($consumption >= $creditUnits) {
            $lowCostConsumption = $creditUnits;
            $highCostConsumption = $consumption - $creditUnits;
        } else if ($consumption < $creditUnits) {
            $lowCostConsumption = $consumption;
            $highCostConsumption = 0;
        }

        $energyCharge = (float) number_format(
            $tariff->energy_charge_normal * $highCostConsumption, 6
        );
        $networkCharge = (float) number_format($tariff->network_charge_normal * ($lowCostConsumption + $highCostConsumption), 6);
        $ancilaryServices = (float) number_format($tariff->ancilary_services_normal * ($lowCostConsumption + $highCostConsumption), 6);
        $publicServiceObligation = (float) number_format($tariff->public_service_obligation  * ($lowCostConsumption + $highCostConsumption), 6);
        $fuelAdjustment = (float) number_format($adjustment->revised_fuel_adjustment_price * $highCostConsumption, 6);
        $total = (float) number_format($energyCharge + $networkCharge + $ancilaryServices + $publicServiceObligation + $fuelAdjustment,  6);
        $vat = (float) number_format(0.19 * $total, 6);
        $total =(float) number_format($total + $vat, 6);

        if ($highCostConsumption > 0) {
            $cost = [
                'energyCharge' => $energyCharge,
                'networkCharge' => $networkCharge,
                'ancilaryServices' => $ancilaryServices,
                'publicServiceObligation' => $publicServiceObligation,
                'fuelAdjustment' => $fuelAdjustment,
                'VAT' => $vat,
                'Total' => $total
            ];
        } else {
            $cost = [
                'networkCharge' => $networkCharge,
                'ancilaryServices' => $ancilaryServices,
                'publicServiceObligation' => $publicServiceObligation,
                'VAT' => $vat,
                'Total' => $total
            ];
        }

        return $cost;
    }
    public function calculateEACCost02(int $consumptionNormal, int $consumptionReduced, DateTime $periodStart, DateTime $periodEnd) :array
    {

        $adjustment = Adjustment::where('consumer_type', "Bi-Monthly")
            ->where('start_date', '<=', $periodStart)
            ->where('end_date', '>=', $periodEnd)
            ->first();

        $tariff = Tariff::where('code', '02')
            ->where('end_date', '=', null)
            ->first();

        $energyCharge = 0;
        $networkCharge = 0;
        $ancilaryServices = 0;
        $publicServiceObligation = 0;
        $fuelAdjustment = 0;


        if ($consumptionNormal > 0 ) {
            $energyCharge = (float) number_format($tariff->energy_charge_normal * $consumptionNormal, 6);
            $networkCharge = (float) number_format($tariff->network_charge_normal * $consumptionNormal, 6);
            $ancilaryServices = (float) number_format($tariff->ancilary_services_normal * $consumptionNormal, 6);
        }
        if ($consumptionReduced > 0 ) {
            $energyCharge += (float) number_format($tariff->energy_charge_reduced * $consumptionReduced, 6);
            $networkCharge += (float) number_format($tariff->network_charge_reduced * $consumptionReduced, 6);
            $ancilaryServices += (float) number_format($tariff->ancilary_services_reduced * $consumptionReduced, 6);
        }
        $publicServiceObligation = (float) number_format($tariff->public_service_obligation * ($consumptionNormal + $consumptionReduced), 6);
        $fuelAdjustment = (float) number_format($adjustment->revised_fuel_adjustment_price * ($consumptionNormal + $consumptionReduced), 6);
        $total = (float) number_format($energyCharge + $networkCharge + $ancilaryServices + $publicServiceObligation + $fuelAdjustment,  6);
        $vat = (float) number_format(0.19 * $total, 6);
        $total =(float) number_format($total + $vat, 6);

        $cost = [
            'energyCharge' => $energyCharge,
            'networkCharge' => $networkCharge,
            'ancilaryServices' => $ancilaryServices,
            'publicServiceObligation' => $publicServiceObligation,
            'fuelAdjustment' => $fuelAdjustment,
            'VAT' => $vat,
            'Total' => $total
        ];

        return $cost;
    }

    public function calculateEACCost08(int $consumption, int $creditUnits, DateTime $periodStart, DateTime $periodEnd): array
    {

        $adjustment = Adjustment::where('consumer_type', "Bi-Monthly")
            ->where('start_date', '<=', $periodStart)
            ->where('end_date', '>=', $periodEnd)
            ->first();

        $tariff = Tariff::where('code', '08')
            ->where('end_date', '=', null)
            ->first();

        if ( ($consumption - $creditUnits) <= 1000 ) {
            $current_energy_charge = $tariff->energy_charge_subsidy_first;
        } elseif ( ($consumption - $creditUnits) > 1000 && ($consumption - $creditUnits) <= 2000 ) {
            $current_energy_charge = $tariff->energy_charge_subsidy_second;
        } elseif ( ($consumption - $creditUnits) > 2000 ) {
            $current_energy_charge = $tariff->energy_charge_subsidy_third;
        }

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
    }
}
