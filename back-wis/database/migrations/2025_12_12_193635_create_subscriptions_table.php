<?php

use App\Models\SubscriptionOffer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'recruiter_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(SubscriptionOffer::class)->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
