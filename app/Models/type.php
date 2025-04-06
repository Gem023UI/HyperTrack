<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    protected $fillable = ['type', 'description'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}