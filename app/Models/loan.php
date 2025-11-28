<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'loaned_at',
        'due_date',
        'returned_at',
        'penalty_amount',
        'penalty_status',
    ];

protected $casts = [
    'loaned_at' => 'datetime',
    'due_date' => 'date',
    'returned_at' => 'datetime',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
