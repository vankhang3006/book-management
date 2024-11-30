<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookCopy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['book_id', 'code', 'status'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function rentalRecord()
    {
        return $this->hasOne(RentalRecord::class, 'book_copy_id');
    }
    
    /**
     * Check if the book copy is available for rental.
     */
    public function isAvailable()
    {
        // If no active rental record exists and status is 'available', the book is available.
        return $this->status === 'available' && !$this->rentalRecord()->whereNull('returned_at')->exists();
    }
}
