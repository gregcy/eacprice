<?php
/**
 * Path: app/Models/User.php
 * Model for system User.
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
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *  Model for System User.
 *
 * @category Models
 * @package  App\Models
 * @author   Greg Andreou <greg.andreou@gmail.com>
 * @license  GPL-3.0 https://opensource.org/license/gpl-3-0/
 * @link     https://github.com/gregcy/eacprice
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the adjustments associated with the current User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function adjustments(): HasMany
    {
        return $this->hasMany(Adjustment::class);
    }

    /**
     * Get the tariffs associated with the current User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tariffs(): HasMany
    {
        return $this->hasMany(Tariff::class);
    }

    /**
     * Get the Costs associated with the current User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function costs(): HasMany
    {
        return $this->hasMany(Cost::class);
    }
}
