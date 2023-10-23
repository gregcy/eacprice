<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cost extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'prefix',
        'suffix',
        'value',
        'source'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
