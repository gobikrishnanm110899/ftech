<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'category_id',
        'subcategory_id',
        'title',
        'slug',
        'price',
        'discount_price',
        'manufacturer_year',
        'fuel_type',
        'km_driven',
        'thumbnail',
        'description',
        'featured',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function gallery()
    {
        return $this->hasMany(VehicleGallery::class)->orderBy('sort_order');
    }

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
    }
}
