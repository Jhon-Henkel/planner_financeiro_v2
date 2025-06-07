<?php

namespace App\Models\Wallet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $name
 * @property float $amount
 * @property bool $hidden
 * @property int $status
 *
 * @mixin Builder<Wallet>
 */
class Wallet extends Model
{
    protected $table = 'wallets';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'amount',
        'hidden',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
