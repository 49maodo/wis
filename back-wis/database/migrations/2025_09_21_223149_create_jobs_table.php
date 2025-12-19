<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->decimal('salary')->nullable();
            $table->string('experienceLevel');
            $table->string('location')->nullable();
            $table->string('sector')->nullable();
            $table->string('jobtype');
            $table->foreignIdFor(User::class, 'creatorId')->constrained('users')->onDelete('cascade');
            $table->date('deadline')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
