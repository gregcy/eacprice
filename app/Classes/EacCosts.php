<?php

namespace App\Classes;

class EacCosts
{
    public float $electricityGeneration;
    public float $networkUsage;
    public float $ancillaryServices;
    public float $meterReading;



    public function __construct()
    {
        $this->eacCosts = [];
    }
}
