<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->index()->unique();
            $table->text('resume')->nullable();
            $table->json('social')->nullable();
            $table->json('experiences')->nullable();
            $table->json('education')->nullable();
            $table->json('languages')->nullable();
            $table->foreignIdFor(App\Models\User::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
