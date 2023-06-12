<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable=[

        "role_id", "title", "category_id", "file_name", "expired_date", "email", "mobile", "tags_for_search"
    ];


    public $timestamps  = false;
}
