<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\OrderDetail;
use App\Models\Product_stock;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // out of stock products
    //admin home page
    public function adminHome()
    {
        // Fetch catalogs with paginated products and product stocks
        $catalogs = Catalog::with(['products' => function ($query) {
            $query->whereNull('deleted_at')->with(['productStocks' => function ($query) {
                $query->where('quantity', '<=', 10);
            }]);
        }])->paginate(5);
        $orders = OrderDetail::with('product')
            ->with('order')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('adminHome', compact('catalogs', 'orders'));
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
            'contact' => 'required',
            'password' => 'required',
        ]);
        $input = ([
            'name' => $request->name,
            'email' => $request->email,
            'contact' => $request->contact,
            'password' => Hash::make($request->password),
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
            'password' => 'nullable|confirmed|min:6',
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
}
