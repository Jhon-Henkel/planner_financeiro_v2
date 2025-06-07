<?php

use App\Infra\Enum\StatusActiveInactiveEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->float('amount', 2)->nullable(false)->default(0);
            $table->boolean('hidden')->default(false);
            $table->integer('status')->default(StatusActiveInactiveEnum::Active);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
