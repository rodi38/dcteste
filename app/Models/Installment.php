<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'number',
        'value',
        'expiration_date',
        'paid',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}
