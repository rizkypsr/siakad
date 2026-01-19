<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curriculum_id')->constrained('curriculums')->cascadeOnDelete();
            $table->string('code');
            $table->string('name');
            $table->integer('sks');
            $table->integer('semester');
            $table->foreignId('prerequisite_course_id')->nullable()->constrained('courses')->nullOnDelete();
            $table->timestamps();

            $table->index('code');
            $table->index('semester');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
