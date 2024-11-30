<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'book_copy_id',
        'user_id',
        'rented_at',
        'due_date',
        'returned_at',
    ];

    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
