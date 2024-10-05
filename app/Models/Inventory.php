<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['character_id'];

    public function items()
    {
        return $this->belongsToMany(Item::class)->withPivot('quantity')->withTimestamps();
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}

