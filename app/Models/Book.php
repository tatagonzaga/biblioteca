<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'description',
        'publisher',
        'publication_year',
        'genre',
        'pages',
        'language',
        'condition',
        'status',
        'location',
        'cover_image',
        'price',
        'quantity',
        'available_quantity',
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'pages' => 'integer',
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'available_quantity' => 'integer',
    ];

    /**
     * Get the categories for the book
     */
    public function categories()
    {
        return $this->belongsToMany(BookCategory::class, 'book_category');
    }

    /**
     * Get the book loans
     */
    public function loans()
    {
        return $this->hasMany(BookLoan::class);
    }

    /**
     * Get the book reservations
     */
    public function reservations()
    {
        return $this->hasMany(BookReservation::class);
    }

    /**
     * Get the book donations
     */
    public function donations()
    {
        return $this->hasMany(BookDonation::class);
    }

    /**
     * Check if book is available for loan
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->available_quantity > 0;
    }

    /**
     * Scope for available books
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('available_quantity', '>', 0);
    }
}
