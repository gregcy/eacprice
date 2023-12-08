<?php

namespace App\Classes;

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

    public function calculateVat(): float
    {
        return $this->vatRate * ($this->electricityGeneration + $this->networkUsage +
        $this->ancillaryServices + $this->meterReading + $this->electricitySupply +
        $this->fuelAdjustment + $this->publicServiceObligation);
    }

    public function calculateTotal(): float
    {
        return round($this->electricityGeneration, 2) + round($this->networkUsage, 2) +
        round($this->ancillaryServices, 2) + round($this->meterReading, 2) +
        round($this->electricitySupply, 2) + round($this->fuelAdjustment, 2)+
        round($this->publicServiceObligation, 2) +round($this->resEsFund, 2) +
        round($this->calculateVat(), 2);
    }

    public function addSource(string $cost, string $description, string $link, string $superscript)
    {
        $this->_sources["$cost"] = [
            'description' => $description,
            'link' => $link,
            'superscript' => $superscript
        ];
    }

    public function getSource(string $cost): array
    {
        return $this->_sources[$cost];
    }

    public function getSourceList(): array
    {
        $sourceList = [];

        foreach ($this->_sources as $key => $value) {
            $sourceList[$value['superscript']] =  [ 'description' => $value['description'] , 'link' => $value['link'] ];
        }

        return $sourceList;
    }
}
