<?php

use App\Models\Job;
use App\Models\Subscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscription_jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('used_quota')->default(1);
            $table->date('assigned_date')->useCurrent()->default(now());
            $table->foreignIdFor(Subscription::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Job::class)->nullable()->constrained()->nullOnDelete();
            $table->timestamps();


            $table->unique(['subscription_id', 'job_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_jobs');
    }
};
