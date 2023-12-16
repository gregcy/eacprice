<?php
/**
 * Path: app/Models/Cost.php
 * Model for EAC Other Costs prices.
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
 * Class Cost
 *  Model for EAC Other Costs prices.
 *
 * @category Models
 * @package  App\Models
 * @author   Greg Andreou <greg.andreou@gmail.com>
 * @license  GPL-3.0 https://opensource.org/license/gpl-3-0/
 * @link     https://github.com/gregcy/eacprice
 */
class Cost extends Model
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
        'name',
        'code',
        'prefix',
        'suffix',
        'value',
        'source',
        'source_name',
    ];

    /**
     * Get the user that owns the cost.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
