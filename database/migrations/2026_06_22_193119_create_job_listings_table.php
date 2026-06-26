<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('company');
            $table->string('location');
            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('type')->default('Full-time'); //full-time, part-time, contractual, internship
            $table->string('experience_level')->default('Entry Level'); //entry level, mid level, senior level
            $table->string('posting_status')->default('live'); //for empoyers: live, screening, closed
            $table->string('status')->default('pending'); //for admins: pending, approved, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
