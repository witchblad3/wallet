<?php

use App\Enum\Transaction\TransactionTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', TransactionTypeEnum::values());
            $table->decimal('amount', 14, 2);
            $table->string('comment')->nullable();
            $table->foreignId('related_user_id')->nullable()->constrained('users');
            $table->uuid('operation_id');
            $table->timestamps();
            $table->index(['user_id', 'created_at']);
            $table->index('operation_id');
        });
    }
    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
