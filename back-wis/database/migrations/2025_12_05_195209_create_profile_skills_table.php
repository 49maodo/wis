<?php

use App\Enums\ExperienceLevel;
use App\Models\Profile;
use App\Models\Skill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profile_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Profile::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Skill::class);
            $table->string('level')->default(ExperienceLevel::DEBUTANT->value);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_skills');
    }
};
