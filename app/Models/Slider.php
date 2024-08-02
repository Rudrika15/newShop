<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'catalogid', 'id');
    }
}
