<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $fillable = [
        'name',
        'description',
        'strength',       // New stat field
        'dexterity',      // New stat field
        'constitution',   // New stat field
        'intelligence',   // New stat field
        'wisdom',         // New stat field
        'charisma',       // New stat field
        'hitpoints',
        'mana',
        'class',       // New field for character class
        'race',        // New field for character race
        'alignment',   // New field for character alignment
        'background',   // New field for character background
        'image_path',  // Field for image path
        'exp'
    ];
    protected $casts = [
        'stats' => 'array',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('level')->withTimestamps();
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
}
