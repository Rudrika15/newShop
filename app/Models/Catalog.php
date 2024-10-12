<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'main_image'
    ];


<<<<<<< HEAD
    public function products()
    {
        return $this->hasMany(Product::class, 'catalogid', 'id');
    }
=======
public function products(){
    return $this->hasMany(Product::class, 'catalogid','id');
}
>>>>>>> 9c148faa03373b20c85430f50b589470dd4cfe44
}
