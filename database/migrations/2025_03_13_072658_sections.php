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
        Schema::create('section_names', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('type', ['listening', 'reading']);
            $table->longText('description');
            $table->timestamps();
        });

        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->string('audio')->nullable();
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('section_name_id');
            $table->foreign('bank_id')->references('id')->on('question_banks')->onDelete('cascade');
            $table->foreign('section_name_id')->references('id')->on('section_names')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
