<?php

/**
 * Path: app/Traits/EACTrait.php
 * Performs all the calculations for the Electricity Cost for EAC
 * php version 8.1.25
 *
 * @category Utilities
 * @package  EACPrice
 * @author   Greg Andreou <greg.andreou@gmail.com>
 * @license  GPL-3.0 https://opensource.org/license/gpl-3-0/
 * @link     https://github.com/gregcy/eacprice
 */

namespace App\Traits;
use App\Models\Tariff;
use App\Models\Adjustment;
use App\Models\Cost;
use DateTime;


/**
 * Trait that provides all calculation methods for the Electricity Cost for EAC
 *
 * @category Utilities
 * @package  EACPrice
 * @author   Greg Andreou <greg.andreou@gmail.com>
 * @license  GPL-3.0 https://opensource.org/license/gpl-3-0/
 * @link     https://github.com/gregcy/eacprice
 */
trait EACTrait
{

    /**
     * Returns the Electricity cost over a period for tariff code 01
     *
     * @param  int      $consumption Consumption in kWh
     * @param  int      $creditUnits Credit Units
     * @param  bool     $includeFixed Include Fixed Charges
     * @param  DateTime $periodStart Period Start date
     * @param  DateTime $periodEnd   Period End date
     *
     * @return array
     */
    public function calculateEACCost01(int $consumption, int $creditUnits, bool $includeFixed, DateTime $periodStart , DateTime $periodEnd): array
    {
        $lowCostConsumption = 0;
        $highCostConsumption = 0;
        $costs = New \stdClass();
        $costs->energyCharge = 0;
        $costs->networkCharge = 0;
        $costs->ancilaryServices = 0;
        $costs->publicServiceObligation = 0;
        $costs->fuelAdjustment = 0;

        if ($consumption >= $creditUnits) {
            $lowCostConsumption = $creditUnits;
            $highCostConsumption = $consumption - $creditUnits;
        } else if ($consumption < $creditUnits) {
            $lowCostConsumption = $consumption;
            $highCostConsumption = 0;
        }

        $tariff = $this->_getTariff('01',  $periodStart, $periodEnd);
        $vatRate = $this->_getVatRate($periodStart, $periodEnd);
        $publicServiceObligation = $this->_getPublicServiceObligation($periodStart, $periodEnd);
        $sources = [
            $tariff->source,
            $publicServiceObligation->source
        ];
        if ($highCostConsumption > 0) {
            $adjustment = $this->_getAdjustment($periodStart, $periodEnd);
            $sources = [
                $tariff->source,
                $adjustment->source,
                $publicServiceObligation->source
            ];
        }

        $costs->energyCharge = (float) $tariff->energy_charge_normal * $highCostConsumption;
        $costs->networkCharge = (float) $tariff->network_charge_normal * ($lowCostConsumption + $highCostConsumption);
        $costs->ancilaryServicesCharge = (float) $tariff->ancilary_services_normal * ($lowCostConsumption + $highCostConsumption);
        $costs->publicServiceObligation = (float) $publicServiceObligation->value * ($lowCostConsumption + $highCostConsumption);
        if ($highCostConsumption > 0) {
            if ($adjustment->revised_fuel_adjustment_price > 0 ) {
                $costs->fuelAdjustment = (float) $adjustment->revised_fuel_adjustment_price * $highCostConsumption;
            } else {
                $costs->fuelAdjustment = (float) $adjustment->fuel_adjustment_price * $highCostConsumption;
            }
        } else {
            $costs->fuelAdjustment = 0;
        }
        if ($includeFixed) {
            $costs->supplyCharge = (float) $tariff->recurring_supply_charge;
            $costs->meterReading = (float) $tariff->recurring_meter_reading;
        } else {
            $costs->supplyCharge = 0;
            $costs->meterReading = 0;
        }
        $costs->vatRate = (float) $vatRate->value;
        $costs->sources = $sources;

        $formattedCosts = $this->_formatCosts($costs);
        return $formattedCosts;
    }

    /**
     * Returns the Electricity cost over a period for tariff code 02
     *
     * @param int      $consumptionNormal  Normal cost consumption in kWh
     * @param int      $consumptionReduced Rediced cost consumpation in kWh
     * @oaram bool     $includeFixed       Include Fixed Charges
     * @param DateTime $periodStart        Period Start date
     * @param DateTime $periodEnd          Period End date
     *
     * @return array
     */
    public function calculateEACCost02(int $consumptionNormal, int $consumptionReduced, bool $includeFixed, DateTime $periodStart, DateTime $periodEnd) :array
    {
        $costs = New \stdClass();
        $costs->energyCharge = 0;
        $costs->networkCharge = 0;
        $costs->ancilaryServices = 0;
        $costs->publicServiceObligation = 0;
        $costs->fuelAdjustment = 0;

        $tariff = $this->_getTariff('02',  $periodStart, $periodEnd);
        $adjustment = $this->_getAdjustment($periodStart, $periodEnd);
        $vatRate = $this->_getVatRate($periodStart, $periodEnd);
        $publicServiceObligation = $this->_getPublicServiceObligation($periodStart, $periodEnd);
        if ($consumptionNormal || $consumptionReduced > 0) {
            $sources = [
                $tariff->source,
                $publicServiceObligation->source,
                $adjustment->source
            ];
        } else {
            $sources = [
                $tariff->source,
            ];
        }

        if ($consumptionNormal > 0 ) {
            $costs->energyCharge = (float) $tariff->energy_charge_normal * $consumptionNormal;
            $costs->networkCharge = (float) $tariff->network_charge_normal * $consumptionNormal;
            $costs->ancilaryServices = (float) $tariff->ancilary_services_normal * $consumptionNormal;
        }
        if ($consumptionReduced > 0 ) {
            $costs->energyCharge += (float) $tariff->energy_charge_reduced * $consumptionReduced;
            $costs->networkCharge += (float) $tariff->network_charge_reduced * $consumptionReduced;
            $costs->ancilaryServices += (float) $tariff->ancilary_services_reduced * $consumptionReduced;
        }
        $costs->publicServiceObligation = (float) $publicServiceObligation->value * ($consumptionNormal + $consumptionReduced);
        if ($adjustment->revised_fuel_adjustment_price > 0 ) {
            $costs->fuelAdjustment = (float) $adjustment->revised_fuel_adjustment_price * ($consumptionNormal + $consumptionReduced);
        } else {
            $costs->fuelAdjustment = (float) $adjustment->fuel_adjustment_price * ($consumptionNormal + $consumptionReduced);
        }
        if ($includeFixed) {
            $costs->supplyCharge = (float) $tariff->recurring_supply_charge;
            $costs->meterReading = (float) $tariff->recurring_meter_reading;
        } else {
            $costs->supplyCharge = 0;
            $costs->meterReading = 0;
        }
        $costs->vatRate = (float) $vatRate->value;
        $costs->sources = $sources;

        $formattedCosts = $this->_formatCosts($costs);
        return $formattedCosts;
    }
    /**
     * Returns the Electricity cost over a period for tariff code 08
     *
     * @param int      $consumption Normal cost consumption in kWh
     * @param int      $creditUnits Rediced cost consumpation in kWh
     * @param bool     $includeFixed Include Fixed Charges
     * @param DateTime $periodStart Period Start date
     * @param DateTime $periodEnd   Period End date
     *
     * @return array
     */
    public function calculateEACCost08(int $consumption, int $creditUnits, bool $includeFixed, DateTime $periodStart, DateTime $periodEnd): array
    {
        $costs = New \stdClass();
        $costs->energyCharge = 0;
        $costs->networkCharge = 0;
        $costs->ancilaryServices = 0;
        $costs->publicServiceObligation = 0;
        $costs->fuelAdjustment = 0;
        $costs->meterReading = 0;

        $tariff = $this->_getTariff('08',  $periodStart, $periodEnd);
        $adjustment = $this->_getAdjustment($periodStart, $periodEnd);
        $vatRate = $this->_getVatRate($periodStart, $periodEnd);
        $sources = [
            $tariff->source,
        ];
        if (($consumption - $creditUnits) > 0) {
            $sources[] = $adjustment->source;
        }

        if (($consumption - $creditUnits) <= 1000) {
            $costs->energyCharge = (float) $tariff->energy_charge_subsidy_first * ($consumption - $creditUnits);
            if ($costs->energyCharge < 0) {
                $costs->energyCharge = 0;
            }
            if ($includeFixed) {
                $costs->supplyCharge = (float) $tariff->supply_subsidy_first;
            } else {
                $costs->supplyCharge = 0;
            }
        } elseif (($consumption - $creditUnits) > 1000 && ($consumption - $creditUnits) <= 2000) {
            $costs->energyCharge = 1000 * $tariff->energy_charge_subsidy_first + ($consumption - $creditUnits - 1000) * $tariff->energy_charge_subsidy_second;
            if ($includeFixed) {
                $costs->supplyCharge = (float) $tariff->supply_subsidy_second;
            } else {
                $costs->supplyCharge = 0;
            }
        } elseif (($consumption - $creditUnits) > 2000) {
            $costs->energyCharge = 2000 * $tariff->energy_charge_subsidy_first + ($consumption - $creditUnits - 2000) * $tariff->energy_charge_subsidy_third;
            if ($includeFixed) {
                $costs->supplyCharge = (float) $tariff->supply_subsidy_third;
            }  else {
                $costs->supplyCharge = 0;
            }

        }
        if ($adjustment->revised_fuel_adjustment_price > 0 ) {
            $costs->fuelAdjustment = (float) $adjustment->revised_fuel_adjustment_price * ($consumption - $creditUnits);
        } else {
            $costs->fuelAdjustment = (float) $adjustment->fuel_adjustment_price * ($consumption - $creditUnits);
        }
        $costs->vatRate = (float) $vatRate->value;
        $costs->sources = $sources;

        $formattedCosts = $this->_formatCosts($costs);
        return $formattedCosts;
    }

    /**
     * Returns the tariffs for a given tariff code and period
     *
     * @param string   $tariff      Tariff code
     * @param DateTime $periodStart Period End date
     * @param DateTime $periodEnd   Period End date
     *
     * @return Tariff
     */
    private function _getTariff(
        string $tariff, DateTime $periodStart , DateTime $periodEnd
    ):Tariff {
        return Tariff::where('code', $tariff)
            ->where(
                function ($query) use ($periodStart, $periodEnd) {
                    $query->where('start_date', '<=', $periodStart)->where(
                        function ($subquery) use ($periodEnd) {
                            $subquery->where('end_date', '>=', $periodEnd)
                                ->orWhereNull('end_date');
                        }
                    );
                }
            )->first();
    }

    /**
     * Returns the fuel adjustment for a given period
     *
     * @param DateTime $periodStart Period Start date
     * @param DateTime $periodEnd   Period End date
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
     * @param DateTime $periodStart Period Start date
     * @param DateTime $periodEnd   Period End date
     *
     * @return Cost
     */
    private function _getVatRate(DateTime $periodStart , DateTime $periodEnd):Cost
    {
        return Cost::where('name', '=', 'VAT')
            ->where(
                function ($query) use ($periodStart, $periodEnd) {
                    $query->where('start_date', '<=', $periodStart)->where(
                        function ($subquery) use ($periodEnd) {
                            $subquery->where('end_date', '>=', $periodEnd)
                                ->orWhereNull('end_date');
                        }
                    );
                }
            )->first();
    }

    /**
     * Returns the Public Service Obligation for a given period
     *
     * @param DateTime $periodStart Period Start date
     * @param DateTime $periodEnd   Period End date
     *
     * @return Cost
     */
    private function _getPublicServiceObligation(DateTime $periodStart , DateTime $periodEnd):Cost
    {
        return Cost::where('name', '=', 'Public Service Obligation')
            ->where(
                function ($query) use ($periodStart, $periodEnd) {
                    $query->where('start_date', '<=', $periodStart)->where(
                        function ($subquery) use ($periodEnd) {
                            $subquery->where('end_date', '>=', $periodEnd)
                                ->orWhereNull('end_date');
                        }
                    );
                }
            )->first();
    }

    /**
     * Returns Electricity cost in an array
     *
     * @param stdClass $costs - Costs object
     *
     * @return array
     */
    private function _formatCosts(\stdClass $costs):array
    {
        $formattedCosts = [];

        $total = 0;
        if ($costs->energyCharge > 0) {
            $formattedCosts['energyCharge'] = (float) number_format(
                $costs->energyCharge, 6, '.', ''
            );
            $total += $costs->energyCharge;
        }
        if ($costs->networkCharge > 0) {
            $formattedCosts['networkCharge'] = (float) number_format(
                $costs->networkCharge, 6, '.', ''
            );
            $total += $costs->networkCharge;
        }
        if ($costs->ancilaryServices > 0) {
            $formattedCosts['ancilaryServices'] = (float) number_format(
                $costs->ancilaryServices, 6, '.', ''
            );
            $total += $costs->ancilaryServices;
        }
        if ($costs->publicServiceObligation > 0) {
            $formattedCosts['publicServiceObligation'] = (float) number_format(
                $costs->publicServiceObligation, 6, '.', ''
            );
            $total += $costs->publicServiceObligation;
        }
        if ($costs->fuelAdjustment > 0) {
            $formattedCosts['fuelAdjustment'] = (float) number_format(
                $costs->fuelAdjustment, 6, '.', ''
            );
            $total += $costs->fuelAdjustment;
        }
        if ($costs->supplyCharge > 0) {
            $formattedCosts['supplyCharge'] = (float) number_format(
                $costs->supplyCharge, 6, '.', ''
            );
            $total += $costs->supplyCharge;
        }
        if ($costs->meterReading > 0) {
            $formattedCosts['meterReading'] = (float) number_format(
                $costs->meterReading, 6, '.', ''
            );
            $total += $costs->meterReading;
        }
        $formattedCosts['vat'] = (float) number_format(
            $costs->vatRate * $total, 6, '.', ''
        );
        $total += $costs->vatRate * $total;
        $formattedCosts['total'] = (float) number_format(
            $total, 6, '.', ''
        );
        $formattedCosts['sources'] = $costs->sources;

        return $formattedCosts;
    }
}
