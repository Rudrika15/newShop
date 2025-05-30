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
    public function productStocks()
    {
        return $this->hasMany(Product_stock::class, 'product_id', 'id');
    }
    public function stockTransaction()
    {
        return $this->hasMany(Stock_Transaction::class, 'product_id', 'id');
    }
    public function getStoke()
    {
        return $this->hasOne(Product_stock::class, 'product_id', 'id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id', 'id');
    }
    
    public function order()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    
}
