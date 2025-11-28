<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'year_published',
        'isbn',
        'genre',
        'quantity',
        'image',
    ];

    /**
     * Get the number of available copies for the book.
     *
     * This is an accessor, so you can access it like a property: $book->available_copies
     */
    public function getAvailableCopiesAttribute()
    {
        // Calculate available copies by subtracting active loans from total quantity.
        // We use withCount for efficiency if the relationship is already loaded.
        if (array_key_exists('loans_count', $this->attributes)) {
            return $this->quantity - $this->loans_count;
        }
        return $this->quantity - $this->loans()->whereNull('returned_at')->count();
    }

    /**
     * The loans associated with the book.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
