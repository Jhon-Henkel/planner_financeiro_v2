<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('expenses_installment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->nullable(false)->index()->constrained('expenses');
            $table->integer('installment_number')->nullable(false);
            $table->float('amount', 2)->nullable(false);
            $table->timestamp('due_date')->nullable(false);
            $table->timestamp('paid_at')->nullable();
            $table->boolean('paid')->default(false);
            $table->string('bank_slip')->nullable();
            $table->text('observations')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses_installment');
    }
};
