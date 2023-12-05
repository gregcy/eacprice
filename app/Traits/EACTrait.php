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
use stdClass;

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
     * @param int      $consumption  Consumption in kWh
     * @param int      $creditUnits  Credit Units
     * @param bool     $includeFixed Include Fixed Charges
     * @param DateTime $periodStart  Period Start date
     * @param DateTime $periodEnd    Period End date
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
        $costs->ancillaryServices = 0;
        $costs->publicServiceObligation = 0;
        $costs->fuelAdjustment = 0;
        $costs->resEsFund = 0;
        $costs->sources = [];

        if ($consumption >= $creditUnits) {
            $lowCostConsumption = $creditUnits;
            $highCostConsumption = $consumption - $creditUnits;
        } else if ($consumption < $creditUnits) {
            $lowCostConsumption = $consumption;
            $highCostConsumption = 0;
        }

        $tariff = $this->getTariff('01',  $periodStart, $periodEnd);
        $vatRate = $this->getVatRate($periodStart, $periodEnd, '01');
        $publicServiceObligation = $this->getPublicServiceObligation($periodStart, $periodEnd);
        $resEsFund = $this->getResEsFund($periodStart, $periodEnd);
        $sources[] = array(
            $tariff->source_name => $tariff->source,
        );
        $sources[] = array(
            $publicServiceObligation->source_name => $publicServiceObligation->source,
        );
        if ($highCostConsumption > 0) {
            $adjustment = $this->getAdjustment($periodStart, $periodEnd);
            $sources[] = array(
                $adjustment->source_name => $adjustment->source,
            );
        }
        $costs->energyCharge = (float) $tariff->energy_charge_normal * $highCostConsumption;
        $costs->networkCharge = (float) $tariff->network_charge_normal * ($lowCostConsumption + $highCostConsumption);
        $costs->ancillaryServices = (float) $tariff->ancillary_services_normal * ($lowCostConsumption + $highCostConsumption);
        $costs->publicServiceObligation = (float) $publicServiceObligation->value * ($lowCostConsumption + $highCostConsumption);
        $costs->resEsFund = (float) $resEsFund->value * $highCostConsumption;
        if ($costs->resEsFund > 0) {
            $sources[] = array(
                $resEsFund->source_name => $resEsFund->source,
            );
        }
        if ($highCostConsumption > 0) {
            if ($adjustment->revised_fuel_adjustment_price > 0 ) {
                $costs->fuelAdjustment = (float) $adjustment->revised_fuel_adjustment_price * $highCostConsumption;
            } else {
                $costs->fuelAdjustment = (float) $adjustment->total * $highCostConsumption;
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
        $formattedCosts = $this->formatCostsCalculator($costs);
        return $formattedCosts;
        dd($formattedCosts);
    }

    /**
     * Returns the Electricity cost over a period for tariff code 02
     *
     * @param int      $consumptionNormal  Normal cost consumption in kWh
     * @param int      $consumptionReduced Rediced cost consumpation in kWh
     * @param bool     $includeFixed       Include Fixed Charges
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
        $costs->ancillaryServices = 0;
        $costs->publicServiceObligation = 0;
        $costs->fuelAdjustment = 0;

        $tariff = $this->getTariff('02',  $periodStart, $periodEnd);
        $adjustment = $this->getAdjustment($periodStart, $periodEnd);
        $vatRate = $this->getVatRate($periodStart, $periodEnd, '02');
        $publicServiceObligation = $this->getPublicServiceObligation($periodStart, $periodEnd);
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
            $costs->ancillaryServices = (float) $tariff->ancillary_services_normal * $consumptionNormal;
        }
        if ($consumptionReduced > 0 ) {
            $costs->energyCharge += (float) $tariff->energy_charge_reduced * $consumptionReduced;
            $costs->networkCharge += (float) $tariff->network_charge_reduced * $consumptionReduced;
            $costs->ancillaryServices += (float) $tariff->ancillary_services_reduced * $consumptionReduced;
        }
        $costs->publicServiceObligation = (float) $publicServiceObligation->value * ($consumptionNormal + $consumptionReduced);
        if ($adjustment->revised_fuel_adjustment_price > 0 ) {
            $costs->fuelAdjustment = (float) $adjustment->revised_fuel_adjustment_price * ($consumptionNormal + $consumptionReduced);
        } else {
            $costs->fuelAdjustment = (float) $adjustment->cost * ($consumptionNormal + $consumptionReduced);
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

        $formattedCosts = $this->formatCostsCalculator($costs);
        return $formattedCosts;
    }
    /**
     * Returns the Electricity cost over a period for tariff code 08
     *
     * @param int      $consumption  Normal cost consumption in kWh
     * @param int      $creditUnits  Rediced cost consumpation in kWh
     * @param bool     $includeFixed Include Fixed Charges
     * @param DateTime $periodStart  Period Start date
     * @param DateTime $periodEnd    Period End date
     *
     * @return array
     */
    public function calculateEACCost08(int $consumption, int $creditUnits, bool $includeFixed, DateTime $periodStart, DateTime $periodEnd): array
    {
        $costs = New \stdClass();
        $costs->energyCharge = 0;
        $costs->networkCharge = 0;
        $costs->ancillaryServices = 0;
        $costs->publicServiceObligation = 0;
        $costs->fuelAdjustment = 0;
        $costs->meterReading = 0;

        $tariff = $this->getTariff('08',  $periodStart, $periodEnd);
        $adjustment = $this->getAdjustment($periodStart, $periodEnd);
        $vatRate = $this->getVatRate($periodStart, $periodEnd, '08');
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
            } else {
                $costs->supplyCharge = 0;
            }

        }
        if ($adjustment->revised_fuel_adjustment_price > 0 ) {
            $costs->fuelAdjustment = (float) $adjustment->revised_fuel_adjustment_price * ($consumption - $creditUnits);
        } else {
            $costs->fuelAdjustment = (float) $adjustment->cost * ($consumption - $creditUnits);
        }
        $costs->vatRate = (float) $vatRate->value;
        $costs->sources = $sources;

        $formattedCosts = $this->formatCostsCalculator($costs);
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
    public function getTariff(
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
    public function getAdjustment(DateTime $periodStart , DateTime $periodEnd):Adjustment
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
     * @param string   $tariffCode  Tariff Code
     *
     * @return Cost
     */
    public function getVatRate(DateTime $periodStart , DateTime $periodEnd, string $tariffCode = null ):Cost
    {
        return Cost::where('name', '=', 'VAT')
            ->where('start_date', '<=', $periodStart)
            ->where(
                function ($query) use ($periodEnd) {
                    $query->where('end_date', '>=', $periodEnd)
                        ->orWhereNull('end_date');
                }
            )
            ->where(
                function ($query1) use ($tariffCode) {
                    $query1->where('code', '=', $tariffCode)
                        ->orWhereNull('code');
                }
            )
        ->first();
    }

    /**
     * Returns the Public Service Obligation for a given period
     *
     * @param DateTime $periodStart Period Start date
     * @param DateTime $periodEnd   Period End date
     *
     * @return Cost
     */
    public function getPublicServiceObligation(DateTime $periodStart , DateTime $periodEnd):Cost
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
     * Returns the RES & ES Fund for a given period
     *
     * @param DateTime $periodStart Period Start date
     * @param DateTime $periodEnd   Period End date
     *
     * @return Cost
     */
    public function getResEsFund(DateTime $periodStart , DateTime $periodEnd):Cost
    {
        return Cost::where('name', '=', 'RES & ES Fund')
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
    public function formatCostsCalculator(\stdClass $costs):array
    {
        //dd($costs);
        $formattedCosts = [];
        $total = 0;
        $vatTotal = 0;
        if ($costs->energyCharge > 0) {
            $formattedCosts['energyCharge'] = new \stdClass();
            $formattedCosts['energyCharge']->value = (float) number_format(
                $costs->energyCharge, 2, '.', ''
            );
            $formattedCosts['energyCharge']->description = __('Electricity Generation');
            $formattedCosts['energyCharge']->color = '#36a2eb';
            $formattedCosts['energyCharge']->sources = $costs->sources[0];
            $total += round($costs->energyCharge, 2);
            $vatTotal += round($costs->energyCharge, 2);
        }
        if ($costs->networkCharge > 0) {
            $formattedCosts['networkCharge'] = new \stdClass();
            $formattedCosts['networkCharge'] ->value = (float) number_format(
                $costs->networkCharge, 2, '.', ''
            );
            $formattedCosts['networkCharge']->description = __('Network Usage');
            $formattedCosts['networkCharge']->color = '#ff6384';
            $formattedCosts['networkCharge']->sources = $costs->sources[0];
            $total += round($costs->networkCharge, 2);
            $vatTotal += round($costs->networkCharge, 2);
        }
        if ($costs->ancillaryServices > 0) {
            $formattedCosts['ancillaryServices'] = new \stdClass();
            $formattedCosts['ancillaryServices']->value = (float) number_format(
                $costs->ancillaryServices, 2, '.', ''
            );
            $formattedCosts['ancillaryServices']->description = __('Ancillary Services');
            $formattedCosts['ancillaryServices']->color = '#ff9f40';
            $formattedCosts['ancillaryServices']->sources = $costs->sources[0];
            $total += round($costs->ancillaryServices, 2);
            $vatTotal += round($costs->ancillaryServices, 2);
        }
        if ($costs->meterReading > 0) {
            $formattedCosts['meterReading'] = new \stdClass();
            $formattedCosts['meterReading']->value =(float) number_format(
                $costs->meterReading, 2, '.', ''
            );
            $formattedCosts['meterReading']->description = __('Meter Reading');
            $formattedCosts['meterReading']->color = '#ffe29d';
            $formattedCosts['meterReading']->sources = $costs->sources[0];
            $total += round($costs->meterReading, 2);
            $vatTotal += round($costs->meterReading, 2);
        }
        if ($costs->supplyCharge > 0) {
            $formattedCosts['supplyCharge'] = new \stdClass();
            $formattedCosts['supplyCharge']->value = (float) number_format(
                $costs->supplyCharge, 2, '.', ''
            );
            $formattedCosts['supplyCharge']->description = __('Electricity Supply');
            $formattedCosts['supplyCharge']->color = '#4bc0c0';
            $formattedCosts['supplyCharge']->sources = $costs->sources[0];
            $total += round($costs->supplyCharge, 2);
            $vatTotal += round($costs->supplyCharge, 2);
        }
        if ($costs->fuelAdjustment > 0) {
            $formattedCosts['fuelAdjustment'] = new \stdClass();
            $formattedCosts['fuelAdjustment']->value = (float) number_format(
                $costs->fuelAdjustment, 2, '.', ''
            );
            $formattedCosts['fuelAdjustment']->description = __('Fuel Adjustment');
            $formattedCosts['fuelAdjustment']->color = '#96f';
            $formattedCosts['fuelAdjustment']->sources = $costs->sources[2];
            $total += round($costs->fuelAdjustment, 2);
            $vatTotal += round($costs->fuelAdjustment, 2);
        }
        if ($costs->publicServiceObligation > 0) {
            $formattedCosts['publicServiceObligation'] = new \stdClass();
            $formattedCosts['publicServiceObligation']->value = (float) number_format(
                $costs->publicServiceObligation, 2, '.', ''
            );
            $formattedCosts['publicServiceObligation']->description = __('Public Service Obligation');
            $formattedCosts['publicServiceObligation']->color = '#c8cace';
            $formattedCosts['publicServiceObligation']->sources = $costs->sources[1];
            $total += round($costs->publicServiceObligation, 2);
            $vatTotal += round($costs->publicServiceObligation, 2);
        }
        if ($costs->resEsFund > 0) {
            $formattedCosts['resEsFund'] = new \stdClass();
            $formattedCosts['resEsFund']->value = (float) number_format(
                $costs->resEsFund, 2, '.', ''
            );
            $formattedCosts['resEsFund']->description = __('RES & ES Fund');
            $formattedCosts['resEsFund']->color = '#63ffde';
            $formattedCosts['resEsFund']->sources = $costs->sources[3];
            $total += round($costs->resEsFund, 2);
            // RES & ES doesn't have VAT
        }

        $formattedCosts['vat'] = new \stdClass();
        $formattedCosts['vat']->value = (float) number_format(
            $costs->vatRate * $vatTotal, 2, '.', ''
        );
        $formattedCosts['vat']->description = __('VAT');
        $formattedCosts['vat']->color = '#ffcd56';

        $total += $costs->vatRate * $vatTotal;
        $formattedCosts['total'] = new \stdClass();
        $formattedCosts['total']->value = (float) number_format(
            $total, 2, '.', ''
        );
        $formattedCosts['total']->description = __('Total');
        return $formattedCosts;
    }
}
