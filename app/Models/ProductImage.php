<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'image_path']; // Allow mass assignment

    /**
     * Define a relationship to the Product model.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor to get the full image URL.
     */
    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }
}
