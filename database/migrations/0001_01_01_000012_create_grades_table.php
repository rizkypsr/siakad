<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dkbs_detail_id')->constrained()->cascadeOnDelete();
            $table->decimal('tugas', 5, 2)->nullable();
            $table->decimal('uts', 5, 2)->nullable();
            $table->decimal('uas', 5, 2)->nullable();
            $table->decimal('final_score', 5, 2)->nullable();
            $table->char('grade_letter', 1)->nullable();
            $table->boolean('is_locked')->default(false);
            $table->timestamps();

            $table->index('grade_letter');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
