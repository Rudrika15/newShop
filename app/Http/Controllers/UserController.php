<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product_stock;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // out of stock products
    //admin home page
    public function adminHome(Request $request)
    {
        $catalogs = Catalog::with(['products' => function ($query) {
            $query->whereNull('deleted_at')->with(['productStocks' => function ($query) {
                $query->where('quantity', '<=', 10);
            }]);
        }])->paginate(5);

        $orders = OrderDetail::with('product')
            ->with('order')
            ->orderBy('created_at', 'desc')
            ->latest()
            ->take(10)
            ->get();

        $catalogs = Catalog::with(['products' => function ($query) {
            $query->whereNull('deleted_at')->withCount('productStocks');
        }])->paginate(5);

        $ordersCount = OrderDetail::with('product')
            ->with('order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Query to get user with the highest orders in the specified date range


        return view('adminHome', compact('catalogs', 'orders'));
    }
    public function sticker()
    {
        $stickers =  OrderDetail::all();

        return view('sticker.index', compact('stickers'));
    }

    public function stickerPrint(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
//print sku also
        $stickers = OrderDetail::whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->pluck('customer_address')
            ;

        $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Customer Addresses</title>
        <style>
            body {
                font-family: \'DejaVu Sans\', sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            td {
                padding: 10px;
                border: none;
                vertical-align: top;
            }
            .address {
                margin-bottom: 20px;
                border-bottom: 1px solid #ddd;
                padding-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <table>
            <tbody>';

        $columnCounter = 0;
        $html .= '<tr>';
        foreach ($stickers as $sticker) {
            if ($columnCounter == 2) {
                $html .= '</tr><tr>';
                $columnCounter = 0;
            }
            $html .= '<td><div class="address">' . $sticker . '<br/>3636001</div></td>';
            $columnCounter++;
        }

        // If there's an odd number of addresses, close the last row properly
        if ($columnCounter > 0) {
            $html .= '</tr>';
        }

        $html .= '</tbody>
        </table>
    </body>
    </html>';

        $pdf = Pdf::loadHTML($html);
        return $pdf->download('addresses' . $from . '-' . $to . '.pdf');
    }


    //user show
    public function index(Request $request)
    {

        $users = User::when($request->input('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('email', 'like', '%' . $request->input('search') . '%')
                ->orWhere('contact', 'like', '%' . $request->input('search') . '%');
        })
            ->where('status', 'Active')
            ->orderBy('created_at', 'desc')->paginate(5);

        return view('user.index', compact('users'));
    }

    //profile
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }



    //trash user data
    public function trashUser()
    {
        $users = User::where('status', 'Deleted')->paginate(5);

        return view('user.trashuser', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'contact' => 'required|min:10|max:10',
         
        ]);
        $input = ([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => Hash::make('123456'),
        ]);

        $user->create($input);
        return \redirect()->route('user.index')
            ->with('success', 'User Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function editpassword(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function password(Request $request, string $id)
    {
        $user = User::find($id);
        return \view('user.changpassword', \compact('user'));
    }

    public function updatepassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6|same:password',
            'oldpassword' => 'required|min:6',
        ]);
        $oldpassword = $request->oldpassword;
        $password = $request->password;

        $userId = Auth::user()->id;


        $user = User::find($userId);
        if (Hash::check($oldpassword, $user->password)) {
            $user->password =   $password;
            $user->save();
        } else {
            return \redirect()->route('user.index')
                ->with('success', 'Old password is incorrect');
        }



        return \redirect()->route('user.index')
            ->with('success', ' Password updated Successfully');
    }

    public function resetPassword($id)
    {
        $user = User::find($id);
        $user->password = Hash::make('123456');
        return redirect()->back()->with('success', 'Password reset successfully');
    }

    public function edit(Request $request, string $id)
    {
        $user = User::find($id);
        return \view('user.edit', \compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'contact' => 'required',
           
        ]);
        $input = $request->all();


        $user->update($input);
        return \redirect()->route('user.index')
            ->with('success', 'User Updated Successfully');
    }

    //soft delete
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {

            $user->status = 'Deleted';
            $user->save();
            return redirect()->back()->with('success', 'User deleted successfully');
        }
        return redirect()->back()->with('success', 'User not found');
    }

    //restore
    public function restore($id)
    {
        $user = User::where('status', 'Deleted')->find($id);
        if ($user) {
            $user->status = 'Active';
            $user->save();

            return redirect()->back()->with('success', 'User restored successfully');
        }
        return redirect()->back()->with('success', 'User not found');
    }

    // permanently delete
    public function destroy($id)
    {
        $user = User::where('status', 'Deleted')->find($id);
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'User permanently deleted successfully');
        }
    }

    //logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out successfully');
    }

    public function reportsUser(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
      
        if ($from && $to) {
            $userReports = Order::whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->with('users')
                ->groupBy('user_id')
                ->select('user_id', DB::raw('COUNT(*) as total_orders'))
                ->orderBy('total_orders', 'desc')
                ->get();


           
        } else {
            $userReports = Order::with('users')
                ->groupBy('user_id')
                ->select('user_id', DB::raw('COUNT(*) as total_orders'))
                ->orderBy('total_orders', 'desc')
                ->get();

           
        }
        

        return view('reports.index-user', compact('userReports'));
    }
    public function reportsCatalog(Request $request)
    {
        $fromC = $request->input('fromC');
        $toC = $request->input('toC');

    
        if ($fromC && $toC) {

            $catalogReport = OrderDetail::select('product_id', DB::raw('COUNT(*) as total_sales'))
                ->whereHas('produc t', function ($query) use ($fromC, $toC) {
                    $query->whereDate('created_at', '>=', $fromC)
                        ->whereDate('created_at', '<=', $toC);
                })
                ->groupBy('product_id')
                ->orderBy('total_sales', 'desc')
                ->with('product.catalog')
                ->get();
        } else {

            $catalogReport = OrderDetail::select('product_id', DB::raw('COUNT(*) as total_sales'))
                ->groupBy('product_id')
                ->orderBy('total_sales', 'desc')
                ->with('product.catalog')
                ->whereHas('product.catalog')
                ->get();
        }

        return view('reports.index-catalog', compact( 'catalogReport'));
    }
}
