<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dkbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('academic_year');
            $table->integer('semester');
            $table->enum('status', ['draft', 'submitted', 'approved'])->default('draft');
            $table->timestamps();

            $table->index('status');
            $table->unique(['student_id', 'academic_year', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dkbs');
    }
};
