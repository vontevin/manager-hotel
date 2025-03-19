<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Add all the fields from the 'customers' table to the $fillable array
    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'phone', 
        'address', 
        'city', 
        'state', 
        'country', 
        'postal_code', 
        'date_of_birth', 
        'identification_type', 
        'identification_number',
        'description',
        'gender',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
