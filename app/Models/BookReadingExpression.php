<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookReadingExpression extends Model
{
    protected $primaryKey = 'expression_id';
    protected $fillable = [
        'user_id','book_id','book_current_page','expression_type','expression_image_name'
    ];
}
