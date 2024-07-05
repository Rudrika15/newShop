<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'catalogid',
        // 'main_image',
        'sku',
        'categoryid',
        'slug',
        'opening_stock',
        'color',
        'size',
        'image',
        'description',
        'base_price',
        'tax_price',
        'discount_amt',
        'mrp',
        'is_active',
    ];
    public function catalog()
    {
        return $this->belongsTo(Catalog::class, 'catalogid', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryid', 'id');
    }
    public function sku()
    {
        return $this->belongsTo(Sku::class, 'skuid', 'id');
    }
}
