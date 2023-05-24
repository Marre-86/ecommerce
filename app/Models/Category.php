<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['parent_id', 'name', 'grandparent_id'];

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id');
    }

    public function childrenWithGrandchildren()
    {
        return $this->hasMany('App\Models\Category', 'parent_id')->with('children');
    }

    public function products()
    {
         return $this->hasMany('App\Models\Product', 'category_id');
    }
}
