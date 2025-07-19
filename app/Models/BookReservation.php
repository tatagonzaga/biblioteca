<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookReservation extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'reservation_date',
        'expiration_date',
        'status',
        'notes',
        'notified_at',
        'position_in_queue',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'expiration_date' => 'date',
        'notified_at' => 'datetime',
    ];

    /**
     * Get the user that made the reservation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was reserved
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if the reservation is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if the reservation has expired
     */
    public function hasExpired()
    {
        return $this->expiration_date && $this->expiration_date < now()->toDateString();
    }

    /**
     * Get active reservations
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get expired reservations
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'active')
                    ->where('expiration_date', '<', Carbon::now());
    }
}
