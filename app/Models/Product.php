<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = ['name', 'price', 'category_id'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function getCategoryNameWithAllParents()
    {
        $category = $this->category;
        $combinedValue = $category->name;

        if ($category->parent) {
            $combinedValue = $category->parent->name . "/" . $category->name;
        }

        if ($category->grandparent) {
            $combinedValue = $category->grandparent->name . "/" . $category->parent->name . "/" . $category->name;
        }

        return $combinedValue;
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('Y-m-d | H:i', strtotime($value)),
        );
    }

    protected function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('Y-m-d | H:i', strtotime($value)),
        );
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }
}
