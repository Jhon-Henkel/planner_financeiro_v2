<?php

namespace App\Models\Wallet;

use App\Models\Movement\Movement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property float $amount
 * @property bool $hidden
 * @property int $status
 *
 * @property-read bool $createMovementOnUpdate
 * @property-read Collection<Movement> $movements
 *
 * @mixin Builder<Wallet>
 */
class Wallet extends Model
{
    protected $table = 'wallets';
    public $timestamps = false;
    public bool $createMovementOnUpdate = true;

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

    public function dontCreateMovementOnUpdate(): void
    {
        $this->createMovementOnUpdate = false;
    }

    /**
     * @return HasMany<Movement, $this>
     */
    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class, 'wallet_id', 'id');
    }
}
