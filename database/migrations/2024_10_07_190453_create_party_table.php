<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('character_id')->constrained()->onDelete('cascade'); // Reference to character
            $table->integer('party_index')->default( 10); // Index for the party
            $table->integer('hitpoints')->default( 10); // Character's hitpoints
            $table->integer('mana')->default(10); // Character's mana
            $table->integer('order')->default(0); // Order of the character in the party
            $table->timestamps(); // Created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('party');
    }
}
