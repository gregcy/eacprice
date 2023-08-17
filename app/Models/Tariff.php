<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tariff extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'code',
        'public_service_obligation',
        'recurring_supply_charge',
        'recurring_meter_reading',
        'energy_charge_normal',
        'energy_charge_reduced',
        'network_charge_normal',
        'network_charge_reduced',
        'ancilary_services_normal',
        'ancilary_services_reduced',
        'energy_charge_subsidy_first',
        'energy_charge_subsidy_second',
        'energy_charge_subsidy_third',
        'supply_subsidy_first',
        'supply_subsidy_second',
        'supply_subsidy_third',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
