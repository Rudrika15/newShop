<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CmsController extends Controller
{
    //
    public function about()
    {
        return view('cms.about');
    }
    public function terms()
    {
        return view('cms.term');
    }
    public function privacy()
    {
        return view('cms.policy');
    }
    public function refund()
    {
        return view('cms.refund');
    }
}
