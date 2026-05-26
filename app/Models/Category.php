<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'status',
    ];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
