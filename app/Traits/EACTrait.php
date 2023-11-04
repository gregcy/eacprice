<?php

/**
 * Path: app/Traits/EACTrait.php
 * Compare this snippet from app/Http/Controllers/GetCurrentRate.php:
 *
 * @author  Greg Andreou <greg.andreou@gmail.com>
 * @license MIT
 *
 */

namespace App\Traits;
use App\Models\Tariff;
use App\Models\Adjustment;
use App\Models\Cost;
use DateTime;

trait EACTrait {

    public function calculateEACCost01(int $consumption, int $creditUnits, DateTime $periodStart , DateTime $periodEnd): array
    {

        $lowCostConsumption = 0;
        $highCostConsumption = 0;

        if ($consumption >= $creditUnits) {
            $lowCostConsumption = $creditUnits;
            $highCostConsumption = $consumption - $creditUnits;
        } else if ($consumption < $creditUnits) {
            $lowCostConsumption = $consumption;
            $highCostConsumption = 0;
        }

        $tariff = $this->_getTariff('01',  $periodStart, $periodEnd);
        $vatRate = $this->_getVatRate($periodStart, $periodEnd);
        $publicServiceObligation = $this->_getPublicServiceObligation($periodStart, $periodEnd)->value;
        $sources = [
            $tariff->source,
            $publicServiceObligation->source
        ];
        if ($highCostConsumption > 0) {
            $adjustment = $this->_getAdjustment($periodStart, $periodEnd);
            $sources[] = $adjustment->source;
        }


        $costs = New \stdClass();

        $costs->energyChargeNormal = (float) $tariff->energy_charge_normal * $highCostConsumption;
        $costs->networkChargeNormal = (float) $tariff->network_charge_normal * ($lowCostConsumption + $highCostConsumption);
        $costs->ancilaryServicesChargeNormal = (float) $tariff->ancilary_services_normal * ($lowCostConsumption + $highCostConsumption);
        $costs->publicServiceObligation = (float) $publicServiceObligation * ($lowCostConsumption + $highCostConsumption);
        $costs->fuelAdjustment = (float) $adjustment->revised_fuel_adjustment_price * $highCostConsumption;
        $costs->supplyCharge = (float) $tariff->recurring_supply_charge;
        $costs->meterReaading = (float) $tariff->recurring_meter_reading;
        $costs->vatRate = (float) $vatRate;
        $costs->sources = $sources;

        $formattedCosts = $this->_formatCosts($costs);

        return $formattedCosts;
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

        $public_service_obligation = Cost::where('name', 'Public Service Obligation')
            ->where('end_date', '=', null)
            ->first();

        $vat_rate = Cost::where('name', 'vat')
            ->where('end_date', '=', null)
            ->first();

        $energyCharge = 0;
        $networkCharge = 0;
        $ancilaryServices = 0;
        $publicServiceObligation = 0;
        $fuelAdjustment = 0;


        if ($consumptionNormal > 0 ) {
            $energyCharge = (float) number_format($tariff->energy_charge_normal * $consumptionNormal, 6, '.', '');
            $networkCharge = (float) number_format($tariff->network_charge_normal * $consumptionNormal, 6, '.', '');
            $ancilaryServices = (float) number_format($tariff->ancilary_services_normal * $consumptionNormal, 6, '.', '');
        }
        if ($consumptionReduced > 0 ) {
            $energyCharge += (float) number_format($tariff->energy_charge_reduced * $consumptionReduced, 6, '.', '');
            $networkCharge += (float) number_format($tariff->network_charge_reduced * $consumptionReduced, 6, '.', '');
            $ancilaryServices += (float) number_format($tariff->ancilary_services_reduced * $consumptionReduced, 6, '.', '');
        }
        $publicServiceObligation = (float) number_format($public_service_obligation->value * ($consumptionNormal + $consumptionReduced), 6, '.', '');
        $fuelAdjustment = (float) number_format($adjustment->revised_fuel_adjustment_price * ($consumptionNormal + $consumptionReduced), 6, '.', '');
        $supplyCharge = (float) number_format($tariff->recurring_supply_charge, 6, '.', '');
        $meterReaading = (float) number_format($tariff->recurring_meter_reading, 6, '.', '');
        $total = (float) number_format($energyCharge + $networkCharge + $ancilaryServices + $publicServiceObligation + $fuelAdjustment, 6, '.', '');
        $vat = (float) number_format($vat_rate->value * $total, 6, '.', '');
        $total =(float) number_format($total + $vat, 6, '.', '');
        $source[] = $tariff->source;
        $source[] = $adjustment->source;
        $source[] = $public_service_obligation->source;


        $cost = [
            'energyCharge' => $energyCharge,
            'networkCharge' => $networkCharge,
            'ancilaryServices' => $ancilaryServices,
            'publicServiceObligation' => $publicServiceObligation,
            'fuelAdjustment' => $fuelAdjustment,
            'supplyCharge' => $supplyCharge,
            'meterReaading' => $meterReaading,
            'vat' => $vat,
            'total' => $total,
            'source' => $source
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

        $vat_rate = Cost::where('name', 'vat')
            ->where('end_date', '=', null)
            ->first();

        $energyCharge = 0;
        $fuelAdjustment = 0;
        $supplyCharge = 0;

        if (($consumption - $creditUnits) <= 1000) {
            $energyCharge = (float) number_format($tariff->energy_charge_subsidy_first * ($consumption - $creditUnits), 6, '.', '');
            if ($energyCharge < 0) {
                $energyCharge = 0;
            }
            $supplyCharge = (float) number_format($tariff->supply_subsidy_first);
        } elseif (($consumption - $creditUnits) > 1000 && ($consumption - $creditUnits) <= 2000) {
            $energyCharge = 1000 * $tariff->energy_charge_subsidy_first + ($consumption - $creditUnits - 1000) * $tariff->energy_charge_subsidy_second;
            $energyCharge = (float) number_format($energyCharge, 6, '.', '');
            $supplyCharge = (float) number_format($tariff->supply_subsidy_second);

        } elseif (($consumption - $creditUnits) > 2000) {
            $energyCharge = 2000 * $tariff->energy_charge_subsidy_first + ($consumption - $creditUnits - 2000) * $tariff->energy_charge_subsidy_third;
            $energyCharge = (float) number_format($energyCharge, 6, '.', '');
            $supplyCharge = (float) number_format($tariff->supply_subsidy_third);
        }
        $fuelAdjustment = (float) number_format($adjustment->revised_fuel_adjustment_price * ($consumption - $creditUnits), 6, '.', '');
        $supplyCharge = (float) number_format($supplyCharge, 6, '.', '');
        $total = (float) number_format($energyCharge + $fuelAdjustment + $supplyCharge, 6, '.', '');
        $vat = (float) number_format($vat_rate->value * $total, 6, '.', '');
        $total = (float) number_format($total + $vat + $supplyCharge, 6, '.', '');
        $source[] = $tariff->source;
        $source[] = $adjustment->source;

        $cost = [
            'energyCharge' => $energyCharge,
            'fuelAdjustment' => $fuelAdjustment,
            'supplyCharge' => $supplyCharge,
            'vat' => $vat,
            'total' => $total,
            'source' => $source
        ];

        return $cost;

    }

    /**
     * Returns the tariffs for a given tariff code and period
     *
     * @param string $tariff
     * @param DateTime $periodStart
     * @param DateTime $periodEnd
     *
     * @return Tariff
     */
    private function _getTariff(
        string $tariff, DateTime $periodStart , DateTime $periodEnd
    ):Tariff {
        return Tariff::where('code', $tariff)
            ->where('start_date', '<=', $periodStart)
            ->where('end_date', '>=', $periodEnd)->orWhereNull('end_date')
            ->first();
    }

    /**
     * Returns the fuel adjustment for a given period
     *
     * @param DateTime $periodStart
     * @param DateTime $periodEnd
     *
     * @return Adjustment
     */
    private function _getAdjustment(DateTime $periodStart , DateTime $periodEnd):Adjustment
    {
        return Adjustment::where('start_date', '<=', $periodStart)
            ->where('end_date', '>=', $periodEnd)
            ->first();
    }

     /**
     * Returns the vat rate for a given period
     *
     * @param DateTime $periodStart
     * @param DateTime $periodEnd
     *
     * @return Cost
     */
    private function _getVatRate(DateTime $periodStart , DateTime $periodEnd):Cost
    {
        return Cost::where('name', 'vat')
            ->where('start_date', '<=', $periodStart)
            ->where('end_date', '>=', $periodEnd)->orWhereNull('end_date')
            ->first();
    }

    /**
     * Returns the Public Service Obligation for a given period
     *
     * @param DateTime $periodStart
     * @param DateTime $periodEnd
     *
     * @return Cost
     */
    private function _getPublicServiceObligation(DateTime $periodStart , DateTime $periodEnd):Cost
    {
        return Cost::where('name', 'Public Service Obligation')
            ->where('start_date', '<=', $periodStart)
            ->where('end_date', '>=', $periodEnd)->orWhereNull('end_date')
            ->first();
    }

    /**
     * Returns Electricity cost in an array
     *
     * @param stdClass $costs
     *
     *@return array
     */
    private function _formatCosts(\stdClass $costs):array {
        $formattedCosts = [];

        $energyCharge = $costs->energyChargeNormal + $costs->energyChargeReduced;
        $networkCharge = $costs->networkChargeNormal + $costs->networkChargeReduced;
        $ancilaryServices = $costs->ancilaryServicesChargeNormal + $costs->ancilaryServicesChargeReduced;
        $total = 0;

        $formattedCosts['energyCharge'] = (float) number_format(
            $energyCharge, 6, '.', '');
        $total += $energyCharge;
        $formattedCosts['networkCharge'] = (float) number_format(
            $networkCharge, 6, '.', '');
        $total += $networkCharge;
        $formattedCosts['ancilaryServices'] = (float) number_format(
            $ancilaryServices, 6, '.', '');
        $total += $ancilaryServices;
        $formattedCosts['publicServiceObligation'] = (float) number_format(
            $costs->publicServiceObligation, 6, '.', '');
        $total += $costs->publicServiceObligation;
        $formattedCosts['fuelAdjustment'] = (float) number_format(
            $costs->fuelAdjustment, 6, '.', '');
        $total += $costs->fuelAdjustment;
        $formattedCosts['supplyCharge'] = (float) number_format(
            $costs->supplyCharge, 6, '.', '');
        $total += $costs->supplyCharge;
        $formattedCosts['meterReaading'] = (float) number_format(
            $costs->meterReaading, 6, '.', '');
        $total += $costs->meterReaading;
        $formattedCosts['vat'] = (float) number_format(
            $costs->vatRate * $total, 6, '.', '');
        $formattedCosts['total'] = (float) number_format(
            $total*(1 +  $costs->vatRate), 6, '.', '');
        $formattedCosts['sources'] = $costs->sources;

        return $formattedCosts;
    }
}
