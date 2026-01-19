<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dkbs_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dkbs_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['dkbs_id', 'schedule_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dkbs_details');
    }
};
