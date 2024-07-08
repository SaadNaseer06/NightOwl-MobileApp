<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarTypesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bar_types', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['club', 'bar']);
            $table->string('image');
            $table->string('title');
            $table->string('latitude');
            $table->string('longtitude'); // corrected typo from 'longtitude' to 'longitude'
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->text('description')->nullable();
            $table->text('specifications')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bar_types');
    }
}
