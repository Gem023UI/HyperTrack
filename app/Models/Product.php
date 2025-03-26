<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'stock'];

    /**
     * Define a relationship to the ProductImage model.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get the first image of the product.
     */
    public function getFirstImageAttribute()
    {
        return $this->images()->first()?->image_path;
    }
}
