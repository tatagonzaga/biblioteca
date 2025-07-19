<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookLoan extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'approved_by',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'notes',
        'fine_amount',
        'fine_paid',
        'renewal_count',
        'max_renewals',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
        'fine_amount' => 'decimal:2',
        'fine_paid' => 'boolean',
        'renewal_count' => 'integer',
        'max_renewals' => 'integer',
    ];

    /**
     * Get the user who borrowed the book
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the borrowed book
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the user that approved the loan
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check if loan is overdue
     */
    public function isOverdue(): bool
    {
        return $this->status === 'active' && Carbon::now()->isAfter($this->due_date);
    }

    /**
     * Check if loan can be renewed
     */
    public function canRenew(): bool
    {
        return $this->status === 'active' && $this->renewal_count < $this->max_renewals;
    }

    /**
     * Calculate fine amount
     */
    public function calculateFine(): float
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        $daysOverdue = Carbon::now()->diffInDays($this->due_date);
        return $daysOverdue * 1.00; // R$ 1,00 per day
    }
}
