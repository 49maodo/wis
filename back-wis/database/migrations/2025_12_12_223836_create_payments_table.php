<?php

use App\Enums\PaymentStatus;
use App\Models\Subscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Subscription::class)->constrained()->nullOnDelete();
            $table->decimal('amount');
            $table->string('payment_method');
            $table->string('payment_status')->default(PaymentStatus::PENDING->value)->index();
            $table->string('transaction_id')->nullable();
            $table->longText('response_details')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
