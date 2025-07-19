<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'cpf',
        'user_type',
        'is_active',
        'birth_date',
        'max_books_allowed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'is_active' => 'boolean',
        ];
    }
    
    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }
    
    /**
     * Check if user can borrow more books
     */
    public function canBorrowBooks(): bool
    {
        return $this->is_active && $this->activeLoans()->count() < $this->max_books_allowed;
    }
    
    /**
     * Get user's active book loans
     */
    public function activeLoans()
    {
        return $this->hasMany(BookLoan::class)->whereIn('status', ['approved', 'active']);
    }
    
    /**
     * Get user's book loans
     */
    public function bookLoans()
    {
        return $this->hasMany(BookLoan::class);
    }
    
    /**
     * Get user's book reservations
     */
    public function bookReservations()
    {
        return $this->hasMany(BookReservation::class);
    }
}
