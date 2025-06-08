<?php

namespace App\Models\Movement;

use App\Models\Wallet\Wallet;
use App\Modules\Movement\Enum\MovementTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $wallet_id
 * @property string $description
 * @property float $amount
 * @property int $type
 *
 * @property-read Wallet $wallet
 *
 * @mixin Builder<Movement>
 */
class Movement extends Model
{
    protected $table = 'movements';
    public $timestamps = false;

    protected $fillable = [
        'wallet_id',
        'description',
        'amount',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return HasOne<Wallet, $this>
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'id', 'wallet_id');
    }

    public function isReceived(): bool
    {
        return $this->type === MovementTypeEnum::Received->value;
    }

    public function isSpent(): bool
    {
        return $this->type === MovementTypeEnum::Spent->value;
    }

    public function isTransfer(): bool
    {
        return $this->type === MovementTypeEnum::Transfer->value;
    }
}
