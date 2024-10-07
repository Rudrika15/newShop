<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Product;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    //
    public function home() {
        return view('visitor.home.home');
    }
    public function product() {
        $data =  Catalog::all();
        return view('visitor.product.product',compact('data'));
    }   
    public function productdetail($id)
    {   
        $data =  Product::where('catalogid', $id)->get();
        return view('visitor.product.productdetail',compact('data'));
    }
    public function contact()
    {
        return view('visitor.contact.contact');
    }
}
