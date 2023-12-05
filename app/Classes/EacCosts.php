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
        return $this->vatRate * ($this->electricityGeneration + $this->networkUsage + $this->ancillaryServices + $this->meterReading + $this->electricitySupply + $this->fuelAdjustment + $this->publicServiceObligation);
    }

    public function calculateTotal(): float
    {
        return $this->electricityGeneration + $this->networkUsage + $this->ancillaryServices + $this->meterReading + $this->electricitySupply + $this->fuelAdjustment + $this->publicServiceObligation + $this->resEsFund + $this->calculateVat();
    }
}
