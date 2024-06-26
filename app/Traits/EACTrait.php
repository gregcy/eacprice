<?php

namespace App\Traits;

use App\Classes\EacCosts;
use App\Models\Adjustment;
use App\Models\Cost;
use App\Models\Tariff;
use Illuminate\Support\Facades\App;
use DateTime;
use DateInterval;
use DatePeriod;
use IntlDateFormatter;
use stdClass;

/**
 * Trait that provides all calculation methods for the Electricity Cost for EAC
 */
trait EACTrait
{
    /**
     * Returns the Electricity cost over a period for tariff code 01
     *
     * @param  float  $consumption  Consumption in kWh
     * @param  float  $creditUnits  Credit Units
     * @param  bool  $includeFixed Include Fixed Charges
     * @param  DateTime  $periodStart  Period Start date
     * @param  DateTime  $periodEnd    Period End date
     */
    public function calculateEACCost01(
        float $consumption,
        float $creditUnits,
        bool $includeFixed,
        DateTime $periodStart,
        DateTime $periodEnd
    ): EacCosts {

        $lowCostConsumption = 0;
        $highCostConsumption = 0;
        $sourcesSuperscript = 1;
        $costs = new EacCosts();

        if ($consumption >= $creditUnits) {
            $lowCostConsumption = $creditUnits;
            $highCostConsumption = $consumption - $creditUnits;
        } elseif ($consumption < $creditUnits) {
            $lowCostConsumption = $consumption;
            $highCostConsumption = 0;
        }
        // Basic Tariff costs
        $tariff = $this->getTariff('01', $periodStart, $periodEnd);
        if ($highCostConsumption > 0) {
            $costs->addSource(
                'electricityGeneration',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
        }
        if ($consumption > 0) {
            $costs->addSource(
                'networkUsage',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
            $costs->addSource(
                'ancillaryServices',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
        }
        if ($includeFixed) {
            $costs->addSource(
                'meterReading',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
            $costs->addSource(
                'electricitySupply',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
        }
        $costs->electricityGeneration
            = $tariff->energy_charge_normal * $highCostConsumption;
        $costs->networkUsage = $tariff->network_charge_normal
            * ($lowCostConsumption + $highCostConsumption);
        $costs->ancillaryServices = $tariff->ancillary_services_normal
            * ($lowCostConsumption + $highCostConsumption);
        if ($includeFixed) {
            $costs->meterReading = $tariff->recurring_meter_reading;
            $costs->electricitySupply = $tariff->recurring_supply_charge;
        } else {
            $costs->meterReading = 0;
            $costs->electricitySupply = 0;
        }
        $sourcesSuperscript++;

        // Fuel Adjustment costs
        if ($highCostConsumption > 0) {
            $adjustment = $this->getAdjustment($periodStart, $periodEnd);
            if ($adjustment->revised_fuel_adjustment_price > 0) {
                $costs->fuelAdjustment =
                    $adjustment->revised_fuel_adjustment_price
                    * $highCostConsumption;
            } else {
                $costs->fuelAdjustment = $adjustment->total
                    * $highCostConsumption;
            }
            $costs->addSource(
                'fuelAdjustment',
                $adjustment->source_name,
                $adjustment->source,
                $sourcesSuperscript
            );
            $sourcesSuperscript++;
        }

        // Public Service Obligation costs
        $publicServiceObligation = $this->getPublicServiceObligation(
            $periodStart,
            $periodEnd
        );
        $costs->publicServiceObligation = $publicServiceObligation->value
            * ($lowCostConsumption + $highCostConsumption);

        if ($costs->publicServiceObligation > 0) {
            $costs->addSource(
                'publicServiceObligation',
                $publicServiceObligation->source_name,
                $publicServiceObligation->source,
                $sourcesSuperscript
            );
            $sourcesSuperscript++;
        }
        // RES & ES Fund costs
        if ($highCostConsumption > 0) {
            $resEsFund = $this->getResEsFund($periodStart, $periodEnd);
            $costs->resEsFund = $resEsFund->value * $highCostConsumption;
            $costs->addSource(
                'resEsFund',
                $resEsFund->source_name,
                $resEsFund->source,
                $sourcesSuperscript
            );
            $sourcesSuperscript++;
        }
        // VAT rate
        $vatRate = $this->getVatRate($periodStart, $periodEnd, '01');
        $costs->vatRate = (float) $vatRate->value;

        return $costs;
    }

    /**
     * Returns the Electricity cost over a period for tariff code 02
     *
     * @param  float  $consumptionNormal  Normal cost consumption in kWh
     * @param  float  $consumptionReduced Rediced cost consumpation in kWh
     * @param  bool  $includeFixed       Include Fixed Charges
     * @param  DateTime  $periodStart        Period Start date
     * @param  DateTime  $periodEnd          Period End date
     */
    public function calculateEACCost02(
        float $consumptionNormal,
        float $consumptionReduced,
        bool $includeFixed,
        DateTime $periodStart,
        DateTime $periodEnd
    ): EacCosts {

        $costs = new EacCosts();
        $sourcesSuperscript = 1;
        // Basic Traiff costs
        $tariff = $this->getTariff('02', $periodStart, $periodEnd);
        if ($consumptionNormal + $consumptionReduced > 0) {
            $costs->addSource(
                'electricityGeneration',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
            $costs->addSource(
                'networkUsage',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
            $costs->addSource(
                'ancillaryServices',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
        }
        if ($includeFixed) {
            $costs->addSource(
                'meterReading',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
            $costs->addSource(
                'electricitySupply',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
        }
        if ($consumptionNormal > 0) {
            $costs->electricityGeneration = $tariff->energy_charge_normal
                * $consumptionNormal;
            $costs->networkUsage = $tariff->network_charge_normal
                * $consumptionNormal;
            $costs->ancillaryServices = $tariff->ancillary_services_normal
                * $consumptionNormal;
        }
        if ($consumptionReduced > 0) {
            $costs->electricityGeneration += $tariff->energy_charge_reduced
                * $consumptionReduced;
            $costs->networkUsage += $tariff->network_charge_reduced
                * $consumptionReduced;
            $costs->ancillaryServices += $tariff->ancillary_services_reduced
                * $consumptionReduced;
        }
        if ($includeFixed) {
            $costs->meterReading = $tariff->recurring_meter_reading;
            $costs->electricitySupply = $tariff->recurring_supply_charge;
        } else {
            $costs->meterReading = 0;
            $costs->electricitySupply = 0;
        }
        $sourcesSuperscript++;

        //Fuel Adjustment costs
        if ($consumptionNormal > 0 || $consumptionReduced > 0) {
            $adjustment = $this->getAdjustment($periodStart, $periodEnd);
            if ($adjustment->revised_fuel_adjustment_price > 0) {
                $costs->fuelAdjustment
                    = $adjustment->revised_fuel_adjustment_price
                        * ($consumptionNormal + $consumptionReduced);
            } else {
                $costs->fuelAdjustment
                    = $adjustment->cost
                        * ($consumptionNormal + $consumptionReduced);
            }
            $costs->addSource(
                'fuelAdjustment',
                $adjustment->source_name,
                $adjustment->source,
                $sourcesSuperscript
            );
            $sourcesSuperscript++;
        }

        //Public Service Obligation costs
        $publicServiceObligation = $this->getPublicServiceObligation(
            $periodStart,
            $periodEnd
        );
        $costs->publicServiceObligation = $publicServiceObligation->value
                * ($consumptionNormal + $consumptionReduced);
        if ($costs->publicServiceObligation > 0) {
            $costs->addSource(
                'publicServiceObligation',
                $publicServiceObligation->source_name,
                $publicServiceObligation->source,
                $sourcesSuperscript
            );
            $sourcesSuperscript++;
        }
        // RES & ES Fund costs
        $resEsFund = $this->getResEsFund($periodStart, $periodEnd);
        $costs->resEsFund = $resEsFund->value
            * ($consumptionNormal + $consumptionReduced);
        if ($costs->resEsFund > 0) {
            $costs->addSource(
                'resEsFund',
                $resEsFund->source_name,
                $resEsFund->source,
                $sourcesSuperscript
            );
            $sourcesSuperscript++;
        }

        // VAT rate
        $vatRate = $this->getVatRate($periodStart, $periodEnd, '02');
        $costs->vatRate = (float) $vatRate->value;

        return $costs;
    }

    /**
     * Returns the Electricity cost over a period for tariff code 08
     *
     * @param  float  $consumption  Normal cost consumption in kWh
     * @param  float  $creditUnits  Rediced cost consumpation in kWh
     * @param  bool  $includeFixed Include Fixed Charges
     * @param  DateTime  $periodStart  Period Start date
     * @param  DateTime  $periodEnd    Period End date
     * @return array
     */
    public function calculateEACCost08(
        float $consumption,
        float $creditUnits,
        bool $includeFixed,
        DateTime $periodStart,
        DateTime $periodEnd
    ): EacCosts {

        $costs = new EacCosts();
        $sourcesSuperscript = 1;

        // Basic Tariff costs
        $tariff = $this->getTariff('08', $periodStart, $periodEnd);
        if (($consumption - $creditUnits) > 0) {
            $costs->addSource(
                'electricityGeneration',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
        }
        if ($includeFixed) {
            $costs->addSource(
                'electricitySupply',
                $tariff->source_name,
                $tariff->source,
                $sourcesSuperscript
            );
        }
        if (($consumption - $creditUnits) <= 1000) {
            $costs->electricityGeneration = $tariff->energy_charge_subsidy_first
                * ($consumption - $creditUnits);
            if ($costs->electricityGeneration < 0) {
                $costs->electricityGeneration = 0;
            }
            if ($includeFixed) {
                $costs->electricitySupply = $tariff->supply_subsidy_first;
            } else {
                $costs->electricitySupply = 0;
            }
        } elseif (
            ($consumption - $creditUnits) > 1000
            && ($consumption - $creditUnits) <= 2000
        ) {
            $costs->electricityGeneration = 1000
                * $tariff->energy_charge_subsidy_first
                + ($consumption - $creditUnits - 1000)
                * $tariff->energy_charge_subsidy_second;
            if ($includeFixed) {
                $costs->electricitySupply = $tariff->supply_subsidy_second;
            } else {
                $costs->electricitySupply = 0;
            }
        } elseif (($consumption - $creditUnits) > 2000) {
            $costs->electricityGeneration = 2000
                * $tariff->energy_charge_subsidy_first
                + ($consumption - $creditUnits - 2000)
                * $tariff->energy_charge_subsidy_third;
            if ($includeFixed) {
                $costs->electricitySupply = $tariff->supply_subsidy_third;
            } else {
                $costs->electricitySupply = 0;
            }
        }
        $sourcesSuperscript++;

        // Fuel Adjustment costs
        if ($consumption - $creditUnits > 0) {
            $adjustment = $this->getAdjustment($periodStart, $periodEnd);
            if ($adjustment->revised_fuel_adjustment_price > 0) {
                $costs->fuelAdjustment =
                    $adjustment->revised_fuel_adjustment_price
                    * ($consumption - $creditUnits);
            } else {
                $costs->fuelAdjustment = $adjustment->cost
                    * ($consumption - $creditUnits);
            }
            $costs->addSource(
                'fuelAdjustment',
                $adjustment->source_name,
                $adjustment->source,
                $sourcesSuperscript
            );
            $sourcesSuperscript++;
        }

        // VAT rate
        $vatRate = $this->getVatRate($periodStart, $periodEnd, '08');
        $costs->vatRate = (float) $vatRate->value;

        return $costs;
    }

    /**
     * Returns the tariffs for a given tariff code and period
     *
     * @param  string  $tariff      Tariff code
     * @param  DateTime  $periodStart Period End date
     * @param  DateTime  $periodEnd   Period End date
     */
    public function getTariff(
        string $tariff,
        DateTime $periodStart,
        DateTime $periodEnd
    ): Tariff {
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
     * @param  DateTime  $periodStart Period Start date
     * @param  DateTime  $periodEnd   Period End date
     */
    public function getAdjustment(
        DateTime $periodStart,
        DateTime $periodEnd
    ): Adjustment {
        return Adjustment::where('start_date', '<=', $periodStart)
            ->where('end_date', '>=', $periodEnd)
            ->first();
    }

    /**
     * Returns the vat rate for a given period
     *
     * @param  DateTime  $periodStart Period Start date
     * @param  DateTime  $periodEnd   Period End date
     * @param  string  $tariffCode  Tariff Code
     */
    public function getVatRate(
        DateTime $periodStart,
        DateTime $periodEnd,
        ?string $tariffCode = null
    ): Cost {
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
     * @param  DateTime  $periodStart Period Start date
     * @param  DateTime  $periodEnd   Period End date
     */
    public function getPublicServiceObligation(
        DateTime $periodStart,
        DateTime $periodEnd
    ): Cost {
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
     * @param  DateTime  $periodStart Period Start date
     * @param  DateTime  $periodEnd   Period End date
     */
    public function getResEsFund(
        DateTime $periodStart,
        DateTime $periodEnd
    ): Cost {
        return Cost::where('name', '=', 'RES and ES Fund')
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
     * Returns Electricity cost in an array for Calculator page
     *
     * @param  EacCosts  $costs - Costs object
     */
    public function formatCostsCalculator(EacCosts $costs): array
    {
        $formattedCosts = [];
        if ($costs->electricityGeneration > 0) {
            $formattedCosts['electricityGeneration'] = new stdClass();
            $formattedCosts['electricityGeneration']->value
                = $costs->electricityGeneration;
            $formattedCosts['electricityGeneration']->description
                = __('Electricity Generation');
            $formattedCosts['electricityGeneration']->color = '#36a2eb';
            $formattedCosts['electricityGeneration']->source
                = $costs->getSource('electricityGeneration');
        }
        if ($costs->networkUsage > 0) {
            $formattedCosts['networkUsage'] = new stdClass();
            $formattedCosts['networkUsage']->value = $costs->networkUsage;
            $formattedCosts['networkUsage']->description = __('Network Usage');
            $formattedCosts['networkUsage']->color = '#ff6384';
            $formattedCosts['networkUsage']->source
                = $costs->getSource('networkUsage');
        }
        if ($costs->ancillaryServices > 0) {
            $formattedCosts['ancillaryServices'] = new stdClass();
            $formattedCosts['ancillaryServices']->value =
                $costs->ancillaryServices;
            $formattedCosts['ancillaryServices']->description
                = __('Ancillary Services');
            $formattedCosts['ancillaryServices']->color = '#ff9f40';
            $formattedCosts['ancillaryServices']->source
                = $costs->getSource('ancillaryServices');
        }
        if ($costs->meterReading > 0) {
            $formattedCosts['meterReading'] = new stdClass();
            $formattedCosts['meterReading']->value = $costs->meterReading;
            $formattedCosts['meterReading']->description = __('Meter Reading');
            $formattedCosts['meterReading']->color = '#ffe29d';
            $formattedCosts['meterReading']->source
                = $costs->getSource('meterReading');
        }
        if ($costs->electricitySupply > 0) {
            $formattedCosts['electricitySupply'] = new stdClass();
            $formattedCosts['electricitySupply']->value =
                $costs->electricitySupply;
            $formattedCosts['electricitySupply']->description
                = __('Electricity Supply');
            $formattedCosts['electricitySupply']->color = '#4bc0c0';
            $formattedCosts['electricitySupply']->source
                = $costs->getSource('electricitySupply');
        }
        if ($costs->fuelAdjustment > 0) {
            $formattedCosts['fuelAdjustment'] = new stdClass();
            $formattedCosts['fuelAdjustment']->value = $costs->fuelAdjustment;
            $formattedCosts['fuelAdjustment']->description =
                __('Fuel Adjustment');
            $formattedCosts['fuelAdjustment']->color = '#96f';
            $formattedCosts['fuelAdjustment']->source
                = $costs->getSource('fuelAdjustment');
        }
        if ($costs->publicServiceObligation > 0) {
            $formattedCosts['publicServiceObligation'] = new stdClass();
            $formattedCosts['publicServiceObligation']->value
                = $costs->publicServiceObligation;
            $formattedCosts['publicServiceObligation']->description
                = __('Public Service Obligation');
            $formattedCosts['publicServiceObligation']->color = '#c8cace';
            $formattedCosts['publicServiceObligation']->source
                = $costs->getSource('publicServiceObligation');
        }
        if ($costs->resEsFund > 0) {
            $formattedCosts['resEsFund'] = new stdClass();
            $formattedCosts['resEsFund']->value = $costs->resEsFund;
            $formattedCosts['resEsFund']->description = __('RES and ES Fund');
            $formattedCosts['resEsFund']->color = '#63ffde';
            $formattedCosts['resEsFund']->source =
                $costs->getSource('resEsFund');
        }
        if ($costs->calculateVat() > 0) {
            $formattedCosts['vat'] = new stdClass();
            $formattedCosts['vat']->value = $costs->calculateVat();
            $formattedCosts['vat']->description
                = __('VAT').' ('.$costs->vatRate * 100 .' %)';
            $formattedCosts['vat']->color = '#ffcd56';
        }

        $formattedCosts['total'] = new stdClass();
        $formattedCosts['total']->value = $costs->calculateTotal();
        $formattedCosts['total']->description = __('Total');
        $formattedCosts['total']->color = 'transparent';

        return $formattedCosts;
    }

    /**
     * Returns Electricity cost in an array for API
     *
     * @param  EacCosts  $costs - Costs object
     */
    public function formatCostsAPI(EacCosts $costs): array
    {
        $apiCosts = [];

        if ($costs->electricityGeneration > 0) {
            $apiCosts['electricityGeneration'] = $costs->electricityGeneration;
        }
        if ($costs->networkUsage > 0) {
            $apiCosts['networkUsage'] = $costs->networkUsage;
        }
        if ($costs->ancillaryServices > 0) {
            $apiCosts['ancillaryServices'] = $costs->ancillaryServices;
        }
        if ($costs->meterReading > 0) {
            $apiCosts['meterReading'] = $costs->meterReading;
        }
        if ($costs->electricitySupply > 0) {
            $apiCosts['electricitySupply'] = $costs->electricitySupply;
        }
        if ($costs->fuelAdjustment > 0) {
            $apiCosts['fuelAdjustment'] = $costs->fuelAdjustment;
        }
        if ($costs->publicServiceObligation > 0) {
            $apiCosts['publicServiceObligation'] =
                $costs->publicServiceObligation;
        }
        if ($costs->resEsFund > 0) {
            $apiCosts['resEsFund'] = $costs->resEsFund;
        }
        $apiCosts['vat'] = $costs->calculateVat(6);
        $apiCosts['total'] = $costs->calculateTotal(6);

        return $apiCosts;
    }

    /**
     * Get the valid periods for which we have pricing data
     * formatted for the calculator dropdown
     *
     * @return array The valid periods.
     */
    public function getValidPeriods(): array
    {
        $periods = [];
        $tariffs = Tariff::select('start_date', 'end_date')->get();
        $adjustments = Adjustment::select('start_date', 'end_date')->get();
        $costs = Cost::select('start_date', 'end_date')->get();
       
        $tariffPeriods = [];
        foreach ($tariffs as $tariff) {
            $period = $this->getMonthsBetweenDates(
                $tariff->start_date,
                $tariff->end_date
            );
            $tariffPeriods = array_merge($tariffPeriods, $period);
        }
        $tariffPeriods = array_unique($tariffPeriods);

        $adjustmentPeriods = [];
        foreach ($adjustments as $adjustment) {
            $period = $this->getMonthsBetweenDates(
                $adjustment->start_date,
                $adjustment->end_date
            );
            $adjustmentPeriods = array_merge($adjustmentPeriods, $period);
        }
        $adjustmentPeriods = array_unique($adjustmentPeriods);

        $costPeriods = [];
        foreach ($costs as $cost) {
            $period = $this->getMonthsBetweenDates(
                $cost->start_date,
                $cost->end_date
            );
            $costPeriods = array_merge($costPeriods, $period);
        }
        $costPeriods = array_unique($costPeriods);

        $periods = array_intersect($tariffPeriods, $adjustmentPeriods, $costPeriods);
        asort($periods);
        $periods = $this->localizeDates($periods);
        
        return $periods;
    }

    function getCurrentValidPeriod(): string
    {
        $periods = $this->getValidPeriods();
        return array_key_last($periods);
    }

    /**
     * Get the months between two dates
     *
     * @param  string  $start_date  The start date
     * @param  string|null  $end_date  The end date
     * @return array The months between the two dates
     */
    public function getMonthsBetweenDates(string $start_date, string|null $end_date): array 
    {
        if ($end_date == null) {
            $end_date = date_format(date_create('now'), 'Y-m-d');
        }
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
    
        // Modify the end date to include the end month
        $end->modify('first day of next month');
    
        $interval = new DateInterval('P1M');
        $period = new DatePeriod($start, $interval, $end);
    
        $months = [];
        foreach ($period as $date) {
            $months[] = $date->format('Y-m');
        }
        return $months;
    }

    /**
     * Localize the dates and outputs them for the Calculator dropdown
     *
     * @param  array  $dates  The dates to localize
     * @return array The localized dates
     */
    function localizeDates(array $dates): array {
        // Define custom month names for Greek locale
        $customMonths = [
            'el' => [
                '01' => 'Ιανουάριος',
                '02' => 'Φεβρουάριος',
                '03' => 'Μάρτιος',
                '04' => 'Απρίλιος',
                '05' => 'Μάιος',
                '06' => 'Ιούνιος',
                '07' => 'Ιούλιος',
                '08' => 'Αύγουστος',
                '09' => 'Σεπτέμβριος',
                '10' => 'Οκτώβριος',
                '11' => 'Νοέμβριος',
                '12' => 'Δεκέμβριος',
            ],
        ];
    
        $result = [];
    
        // Get the current locale in Laravel
        $locale = App::getLocale();
    
        foreach ($dates as $date) {
            // Convert to DateTime object
            $dateTime = DateTime::createFromFormat('Y-m', $date);
    
            // Ensure DateTime object is valid
            if ($dateTime) {
                if (isset($customMonths[$locale])) {
                    // Use custom month names for the locale
                    $year = $dateTime->format('Y');
                    $month = $dateTime->format('m');
                    $formattedDate = $customMonths[$locale][$month] . ' ' . $year;
                } else {
                    // Use IntlDateFormatter for other locales
                    $formatter = new IntlDateFormatter(
                        $locale,
                        IntlDateFormatter::LONG,
                        IntlDateFormatter::NONE,
                        null,
                        null,
                        'MMMM yyyy'
                    );
                    $formattedDate = $formatter->format($dateTime);
                }
    
                // Add to result array
                $result[$date] = $formattedDate;
            }
        }
    
        return $result;
    }
}
