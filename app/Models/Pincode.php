<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    use HasFactory;
    
    // protected $table = "pincodes";

    protected $table = 'pincodes';

    // Optionally, specify fillable fields if using mass assignment
    protected $fillable = ['state', 'district', 'city', 'pincode', 'isDeliverable', 'deliveryCharges'];
}

