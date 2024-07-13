<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock_Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'quantity',
        'type',
        'remarks'
    ];
    
    protected $table = "stock_transactions";

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
