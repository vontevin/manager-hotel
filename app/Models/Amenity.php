<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = ['name','description'];

    public function roomTypes()
    {
        return $this->belongsToMany(RoomType::class, 'amenity_room_type', 'amenity_id', 'room_type_id');
    }
    
}

