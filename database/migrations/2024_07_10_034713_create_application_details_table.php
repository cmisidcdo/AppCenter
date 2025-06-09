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
        Schema::create('application_details', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id');
            $table->integer('release_number')->nullable();
            $table->string('release_version')->nullable();
            $table->string('file_size')->nullable();
            $table->string('release_notes')->nullable();
            $table->string('file_location')->nullable();
            $table->integer('is_public')->default(0);
            $table->integer('total_downloads')->default(0);
            $table->integer('is_active')->default(1);
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_details');
    }
};
