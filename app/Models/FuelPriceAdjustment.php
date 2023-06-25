<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuelPriceAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'consumer_type',
        'weighted_average_fuel_price',
        'fuel_adjustment_coefficient',
        'voltage_type',
        'total',
        'fuel',
        'co2_emissions',
        'cosmos',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
