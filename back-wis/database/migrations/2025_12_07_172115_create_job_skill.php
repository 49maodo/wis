<?php

use App\Enums\ExperienceLevel;
use App\Models\Job;
use App\Models\Skill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Job::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Skill::class);
            $table->string('level')->default(ExperienceLevel::DEBUTANT->value);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_skill');
    }
};
