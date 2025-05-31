<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('test_scores', function (Blueprint $table) {
            $table->id();
            $table->uuid('slug');
            $table->unsignedBigInteger('school_year_id');
            $table->unsignedBigInteger('student_id');
            $table->integer('rank')->nullable();
            $table->float('avg_score')->default(0);
            $table->timestamps();

            $table->foreign('school_year_id')->references('id')->on('school_years')->restrictOnDelete();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_scores');
    }
};
