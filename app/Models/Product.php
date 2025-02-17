<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'id',
        'product_name',
        'section_id',
        'description'
    ];
    public function sections()  {
        return $this->belongsTo(Section::class, 'section_id'); // Foreign key in `products` table


    }

}
