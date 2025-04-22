<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['categoryname', 'parent'];

    public function products()
    {
        return $this->hasMany(Product::class, 'categoryid', 'id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent', 'id');
    }
    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent');
    }
}
