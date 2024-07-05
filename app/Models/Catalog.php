<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'main_image'
    ];


public function products(){
    return $this->hasMany(Product::class, 'catalogid','id');
}
}
