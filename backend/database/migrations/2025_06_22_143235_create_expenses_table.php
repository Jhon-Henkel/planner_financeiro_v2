<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable(false);
            $table->integer('type')->nullable(false);
            $table->boolean('variable')->default(false);
            $table->float('amount', 2)->nullable(false);
            $table->date('date_start')->nullable(false);
            $table->date('date_end')->nullable();
            $table->integer('total_installments')->nullable();
            $table->integer('recurrence_interval')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
