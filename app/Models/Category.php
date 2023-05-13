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

    public function products()
    {
        // каждый статус может содержаться в множестве задач
        // hasMany определяется у модели, имеющей внешние ключи в других таблицах
        return $this->hasMany('App\Models\Product', 'category_id');
    }
}
