<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property int $expense_id
 * @property int $installment_number
 * @property float $amount
 * @property string $due_date
 * @property string $paid_at
 * @property bool $paid
 * @property null|string $bank_slip
 * @property null|string $observations
 * @property string $created_at
 * @property string $updated_at
 *
 * @property-read Expense $expense
 *
 * @mixin Builder<ExpenseInstallment>
 */
class ExpenseInstallment extends Model
{
    protected $table = 'expenses_installments';
    public $timestamps = false;

    protected $fillable = [
        'expense_id',
        'installment_number',
        'amount',
        'due_date',
        'paid_at',
        'paid',
        'bank_slip',
        'observations'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'paid_at' => 'datetime',
        'due_date' => 'datetime',
        'paid' => 'boolean',
    ];

    /**
     * @return HasOne<Expense, $this>
     */
    public function expense(): HasOne
    {
        return $this->hasOne(Expense::class, 'id', 'expense_id');
    }
}
