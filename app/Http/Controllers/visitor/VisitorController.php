<?php

namespace App\Http\Controllers\visitor;

use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    //
    public function home()

    {
        $data = Slider::all();
        return view('visitor.home.home',compact('data'));
    }

    public function product()
    {
        $data =  Catalog::all();
        return view('visitor.product.product', compact('data'));
    }

    public function productdetail($id)
    {
        $catalogs = Catalog::where('id', $id)->first();
        $products =  Product::where('catalogid', $id)->get();
        return view('visitor.product.productDetail', compact('catalogs', 'products'));
    }

    public function contact()
    {
        return view('visitor.contact.contact');
    }
}
