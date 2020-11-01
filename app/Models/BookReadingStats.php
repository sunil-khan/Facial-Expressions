<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReadingStats extends Model
{
    protected $table ='book_reading_stats';
    protected $primaryKey = 'stats_id';
    protected $fillable = [
        'reading_id','book_page_number','start_time','end_time',
    ];

}
