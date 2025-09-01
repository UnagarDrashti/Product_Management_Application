<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category',
        'stock'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('storage/products/default-product.png');
        }

        return Str::startsWith($this->image, ['http://', 'https://'])
            ? $this->image
            : Storage::url($this->image);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
