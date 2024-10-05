<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name', 'description', 'image_path',];

    public function characters()
    {
        return $this->belongsToMany(Character::class)->withPivot('level')->withTimestamps();
    }
}
