<?php

/**
 * Path: app/Classes/EacCosts.php
 * Data scructure and calculations for EAC bill items.
 * php version 8.2
 *
 * @category Utilities
 *
 * @author  Greg Andreou <greg.andreou@gmail.com>
 * @license GPL-3.0 https://opensource.org/license/gpl-3-0/
 *
 * @link https://github.com/gregcy/eacprice
 */

namespace App\Classes;

/**
 * Class EacCosts.
 *  Data scructure and calculations for EAC bill items.
 * @category Utilities
 *
 */
class EacCosts
{
    public float $electricityGeneration;

    public float $networkUsage;

    public float $ancillaryServices;

    public float $meterReading;

    public float $electricitySupply;

    public float $fuelAdjustment;

    public float $publicServiceObligation;

    public float $resEsFund;

    public float $vatRate;

    private array $_sources;

    public function __construct()
    {
        $this->electricityGeneration = 0;
        $this->networkUsage = 0;
        $this->ancillaryServices = 0;
        $this->meterReading = 0;
        $this->electricitySupply = 0;
        $this->fuelAdjustment = 0;
        $this->publicServiceObligation = 0;
        $this->resEsFund = 0;
        $this->vatRate = 0;
    }

    /**
     * Calculates the VAT cost of the electricity consumption.
     *
     * @param integer $decimals The number of decimal places to use for calculations
     *                          and to round result to.
     *
     * @return float
     */
    public function calculateVat(int $decimals = 2): float
    {
        return round(
            $this->vatRate * ($this->electricityGeneration + $this->networkUsage +
            $this->ancillaryServices + $this->meterReading + $this->electricitySupply +
            $this->fuelAdjustment + $this->publicServiceObligation), $decimals
        );
    }

    /**
     * Calculates the total cost of the electricity consumption.
     *
     * @param integer $decimals The number of decimal places to use for calculations
     *                          and to round result to.
     *
     * @return float
     */
    public function calculateTotal(int $decimals = 2): float
    {
        return round(
            round($this->electricityGeneration, $decimals) +
            round($this->networkUsage, $decimals) +
            round($this->ancillaryServices, $decimals) +
            round($this->meterReading, $decimals) +
            round($this->electricitySupply, $decimals) +
            round($this->fuelAdjustment, $decimals) +
            round($this->publicServiceObligation, $decimals) +
            round($this->resEsFund, $decimals) +
            round($this->calculateVat(), $decimals), $decimals
        );
    }

    /**
     * Adds a source for a cost to the list of sources.
     *
     * @param string $cost        The cost associated with the source.
     * @param string $description The description of the source.
     * @param string $link        The link to the source.
     * @param string $superscript The superscript to use for the source.
     *
     * @return float
     */
    public function addSource(
        string $cost, string $description,
        string $link, string $superscript
    ): void {
        $this->_sources["$cost"] = [
            'description' => $description,
            'link' => $link,
            'superscript' => $superscript,
        ];
    }

    /**
     * Returns the source for a specific cost.
     *
     * @param string $cost The cost associated with the source.
     *
     * @return array
     */
    public function getSource(string $cost): array
    {
        return $this->_sources[$cost];
    }

    /**
     * Returns a list of source associated with th calculations.
     *
     * @return array
     */
    public function getSourceList(): array
    {
        $sourceList = [];
        if (isset($this->_sources)) {
            foreach ($this->_sources as $key => $value) {
                $sourceList[$value['superscript']] = ['description' => $value['description'], 'link' => $value['link']];
            }
        }

        return $sourceList;
    }
}
