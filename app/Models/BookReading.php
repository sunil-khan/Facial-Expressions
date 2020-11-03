<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReading extends Model
{
    protected $primaryKey = 'reading_id';
    protected $fillable = [
        'user_id','book_id','book_total_pages','book_current_page',
    ];

    function BookStats()
    {
        return $this->hasMany(BookReadingStats::class,'reading_id','reading_id');
    }
}
