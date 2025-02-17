<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable=[
        'id',
       'section_name',
       'description',
       'created_by'

    ];
}
