<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'vehicle_id',
        'name',
        'city',
        'phone',
        'message',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
