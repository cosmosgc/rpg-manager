<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $table = 'party'; // Define the table name if it's not the plural 'parties'

    // Define the fillable attributes to allow mass assignment
    protected $fillable = [
        'character_id',
        'party_index',
        'hitpoints',
        'mana',
        'order',
    ];

    /**
     * Get the character that belongs to the party.
     */
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
