<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_type',
        'custom_type',
        'full_name',
        'phone',
        'address_line1',  // Note: no underscore between line and 1
        'address_line2',
        'city',
        'state',
        'zip',           // Note: it's 'zip' not 'postal_code'
        'country',
        'pickup_address',
        'delivery_address',
        'is_default',
        'instructions',
    ];

    protected $casts = [
        'pickup_address' => 'boolean',
        'delivery_address' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        $address = $this->address_line1;
        
        if ($this->address_line2) {
            $address .= ', ' . $this->address_line2;
        }
        
        $address .= ', ' . $this->city . ', ' . $this->state . ' ' . $this->zip;
        
        return $address;
    }
}