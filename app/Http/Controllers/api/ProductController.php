<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Pincode;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductList()
    {
        $catalogs = Catalog::with('products')->get();
        return response()->json($catalogs);
    }

}
