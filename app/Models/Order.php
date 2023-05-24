<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'phone'];

    public function created_by()            // phpcs:ignore
    {
        return $this->belongsTo('App\Models\User');
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => date('Y-m-d | H:i', strtotime($value)),
        );
    }
}
