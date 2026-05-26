<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleGallery extends Model
{
    protected $table = 'vehicle_gallery';

    protected $fillable = [
        'vehicle_id',
        'file',
        'type',
        'sort_order',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
