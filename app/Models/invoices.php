<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    protected $guarded = [];
    protected $date = ['deleted_at'];
    use SoftDeletes;
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id'); // Foreign key in `products` table

    }
}
