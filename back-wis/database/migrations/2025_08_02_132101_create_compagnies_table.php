<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('compagnies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compagnies');
    }
};
