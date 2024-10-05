<?php

namespace App\Http\Controllers\api;

use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function getCategoryfilter(Request $req)
    {
        $data = $req->categoryname;

        $categories = Category::where('categoryname', 'like', '%' . $data . '%')->get();
        if ($categories->isNotEmpty()) {
            return Util::getCategoryListResponse($categories);
        } else {
            return response()->json(["message" => "not found"]);
        }
    }
}
