<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sku extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'prefix',
        'colorname'
    ];
    public function products(){
        return $this->hasMany(Product::class, 'skuid','id');
    }
}
