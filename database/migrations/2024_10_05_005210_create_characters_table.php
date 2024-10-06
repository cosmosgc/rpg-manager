<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('exp')->default(1);
             // Individual columns for each stat with default values
            $table->integer('strength')->default(0);
            $table->integer('dexterity')->default(0);
            $table->integer('constitution')->default(0);
            $table->integer('intelligence')->default(0);
            $table->integer('wisdom')->default(0);
            $table->integer('charisma')->default(0);

            $table->integer('hitpoints');
            $table->integer('mana');
            $table->string('class')->nullable(); // New column for character class
            $table->string('race')->nullable(); // New column for character race
            $table->string('alignment')->nullable(); // New column for character alignment
            $table->string('background')->nullable(); // New column for character background
            $table->string('image_path')->nullable(); // Column for image path
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
