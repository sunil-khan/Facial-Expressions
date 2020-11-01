<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $primaryKey = 'book_id';
    protected $fillable = [
        'book_title','book_author_name','book_slug','book_thumb','book_file','book_status',
    ];
}
