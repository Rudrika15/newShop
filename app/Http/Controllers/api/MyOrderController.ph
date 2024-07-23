<?php

namespace App\Http\Controllers\api;

use App\Helper\Util;
use App\Http\Controllers\Controller;
use App\Models\Myorder;
use Illuminate\Http\Request;

class MyOrderController extends Controller
{
    public function getMyorderList(){

        $myorder =  Myorder::all();

        return Util::getMyorderListResponse($myorder);
    }
}
