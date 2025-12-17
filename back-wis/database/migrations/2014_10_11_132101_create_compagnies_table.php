<?php

use App\Enums\VerificationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('compagnies', function (Blueprint $table) {
            $table->id();
            $table->string('ninea')->nullable();
            $table->string('rccm')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('status')->default(VerificationStatus::PENDING->value);
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compagnies');
    }
};
