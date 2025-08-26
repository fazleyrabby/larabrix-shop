<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // public function children()
    // {
    //     return $this->hasMany(self::class, 'parent_id', 'id');
    // }

    // public function parent()
    // {
    //     return $this->belongsTo(self::class, 'parent_id');
    // }

    // public function childrenRecursive()
    // {
    //     return $this->children()->with('childrenRecursive');
    // }
}
