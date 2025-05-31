<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('test_score_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_score_id');
            $table->unsignedBigInteger('course_id');
            $table->float('score');
            $table->timestamps();

            $table->foreign('test_score_id')->references('id')->on('test_scores')->cascadeOnDelete();
            $table->foreign('course_id')->references('id')->on('courses')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_score_details');
    }
};
