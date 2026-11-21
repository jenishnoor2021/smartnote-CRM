<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributorApplication extends Model
{
    use HasFactory;

    protected $table = 'distributor_applications';

    protected $fillable = [
        'trader_name',
        'firm_name',
        'phone',
        'email',
        'city',
        'address',
        'state',
        'pincode',
        'gst_number',
        'business_type',
        'experience_years',
        'current_brands',
        'message',
        'status',
        'notes',
    ];

    /**
     * Address fallback accessor
     */
    public function getAddressAttribute()
    {
        if (!empty($this->attributes['address'])) {
            return $this->attributes['address'];
        }

        $parts = array_filter([$this->city, $this->state, $this->pincode]);
        return !empty($parts) ? implode(', ', $parts) : null;
    }
}
