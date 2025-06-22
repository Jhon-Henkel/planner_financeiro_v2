<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $description
 * @property int $type
 * @property bool $variable
 * @property float $amount
 * @property string $date_start
 * @property string $date_end
 * @property int $total_installments
 * @property int $recurrence_interval
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Collection<ExpenseInstallment> $installments
 *
 * @mixin Builder<Expense>
 */
class Expense extends Model
{
    protected $table = 'expenses';
    public $timestamps = false;

    protected $fillable = [
        'description',
        'type',
        'variable',
        'amount',
        'date_start',
        'date_end',
        'total_installments',
        'recurrence_interval'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'variable' => 'boolean',
    ];

    /**
     * @return HasMany<ExpenseInstallment, $this>
     */
    public function installments(): HasMany
    {
        return $this->hasMany(ExpenseInstallment::class, 'expense_id', 'id');
    }
}
