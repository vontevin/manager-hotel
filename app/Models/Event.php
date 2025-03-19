<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_name',
        'event_start_date',
        'event_end_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'event_start_date' => 'datetime',
        'event_end_date' => 'datetime',
    ];

    /**
     * Scope for filtering events based on provided filters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter(Builder $query, array $filters)
    {
        if ($filters['event_name'] ?? false) {
            $query->where('event_name', 'like', '%' . $filters['event_name'] . '%');
        }

        if ($filters['event_start_date'] ?? false) {
            $query->whereDate('event_start_date', '>=', $filters['event_start_date']);
        }

        if ($filters['event_end_date'] ?? false) {
            $query->whereDate('event_end_date', '<=', $filters['event_end_date']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
    
        if (isset($filters['date'])) {
            $query->whereDate('created_at', $filters['date']);
        }
    
        return $query;
    }

}
