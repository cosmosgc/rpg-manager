<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['name', 'description', 'quantity', 'image_path',];

    public function inventories()
    {
        return $this->belongsToMany(Inventory::class)->withPivot('quantity')->withTimestamps();
    }
}
