<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'child', 
        'adult', 
        'image', 
        'is_active'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'amenity_room_type', 'room_type_id', 'amenity_id');
    }
}
