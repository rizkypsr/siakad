<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nim')->unique();
            $table->foreignId('study_program_id')->constrained()->cascadeOnDelete();
            $table->year('year_of_entry');
            $table->enum('status', ['aktif', 'cuti', 'lulus'])->default('aktif');
            $table->timestamps();

            $table->index('status');
            $table->index('year_of_entry');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
