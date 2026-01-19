<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('nim')->nullable()->change();
            $table->enum('registration_status', ['pending', 'approved', 'rejected'])->default('pending')->after('status');
            
            // Biodata tambahan
            $table->string('phone')->nullable()->after('registration_status');
            $table->text('address')->nullable()->after('phone');
            $table->date('birth_date')->nullable()->after('address');
            $table->string('birth_place')->nullable()->after('birth_date');
            $table->enum('gender', ['L', 'P'])->nullable()->after('birth_place');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('nim')->nullable(false)->change();
            $table->dropColumn(['registration_status', 'phone', 'address', 'birth_date', 'birth_place', 'gender']);
        });
    }
};
