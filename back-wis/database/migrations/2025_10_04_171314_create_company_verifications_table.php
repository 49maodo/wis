<?php

use App\Enums\VerificationStatus;
use App\Models\Compagny;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('compagny_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Compagny::class)->constrained('compagnies');
            $table->foreignIdFor(User::class, 'submitted_by')->constrained('users');
            $table->string('status')->default(VerificationStatus::PENDING->value);;
            $table->string('ninea');
            $table->string('rccm')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compagny_verifications');
    }
};
