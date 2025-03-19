<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'room_id', 'check_in', 'check_out', 
        'total_price', 'status', 'number_of_rooms',
        'description', 'booking_source', 'booking_reference', 'number_of_adults', 'number_of_children',
        'actual_check_in' => 'datetime',
        'actual_check_out' => 'datetime',
    ];
    
    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'actual_check_in' => 'datetime',
        'actual_check_out' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function scopeFilter(Builder $query, $filters)
    {
        if (!empty($filters['customer_name'])) {
            $query->whereHas('customer', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['customer_name'] . '%');
            });
        }

        if (!empty($filters['check_in'])) {
            $query->whereDate('check_in', '>=', $filters['check_in']);
        }

        if (!empty($filters['check_out'])) {
            $query->whereDate('check_out', '<=', $filters['check_out']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['room_id'])) {
            $query->where('room_id', $filters['room_id']);
        }

        return $query;
    }
    
}

