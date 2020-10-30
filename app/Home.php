<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{

    protected $table = 'reader_data';
    protected $primaryKey = 'reader_id';
    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = [
    	'reader_user_id','reader_page_no','reader_book_id','reader_book_title','reader_created_at',
    ];

}
