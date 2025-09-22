<?php

use App\Enums\ApplicationStatus;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->string('cv');
            $table->string('status')->default(ApplicationStatus::PENDING->value);
            $table->foreignIdFor(User::class, 'candidat_id')->constrained('users')->onDelete('cascade');
            $table->foreignIdFor(Job::class)->constrained('jobs')->onDelete('cascade');
            $table->unique(['candidat_id', 'job_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
