<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transcripts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->integer('semester');
            $table->decimal('gpa', 4, 2); // IP semester
            $table->decimal('cgpa', 4, 2)->nullable(); // IPK kumulatif
            $table->timestamps();

            $table->unique(['student_id', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transcripts');
    }
};
