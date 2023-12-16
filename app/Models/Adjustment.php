<?php
/**
 * Path: app/Models/Adjustment.php
 * Model for EAC Fuel Adjustment prices.
 * php version 8.2
 *
 * @category Models
 * @package  App\Models
 * @author   Greg Andreou <greg.andreou@gmail.com>
 * @license  GPL-3.0 https://opensource.org/license/gpl-3-0/
 * @link     https://github.com/gregcy/eacprice
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Adjustment
 * Data scructure for EAC Fuel Adjustment prices.
 *
 * @category Models
 * @package  App\Models
 * @author   Greg Andreou <greg.andreou@gmail.com>
 * @license  GPL-3.0 https://opensource.org/license/gpl-3-0/
 * @link     https://github.com/gregcy/eacprice
 */
class Adjustment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, \DateTime>
     */
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
        'revised_fuel_adjustment_price',
        'source',
        'source_name',

    ];

    /**
     * Get the user that owns the adjustment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
