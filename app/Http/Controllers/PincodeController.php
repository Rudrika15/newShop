<?php

namespace App\Http\Controllers;

use App\Models\Pincode;
use Illuminate\Http\Request;

class PincodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pincode.index');
    }

    /**
     * Fetch pincodes for AJAX request.
     */
    public function fetchPincodes(Request $request)
{
    if ($request->ajax()) {
        $query = $request->get('query', '');

        $pincodes = Pincode::where('state', 'like', "%{$query}%")
            ->orWhere('district', 'like', "%{$query}%")
            ->orWhere('city', 'like', "%{$query}%")
            ->orWhere('pincode', 'like', "%{$query}%")
            ->paginate(500);

        return response()->json([
            'pincodes' => $pincodes,
            'pagination' => (string) $pincodes->links('pagination::bootstrap-5'),
        ]);
    }
}


    /**
     * Update the specified pincode field.
     */
    public function updatePincode(Request $request)
    {
        $pincode = Pincode::find($request->id);
        $pincode->{$request->field} = $request->value;
        $pincode->save();

        return response()->json(['message' => 'Pincode updated successfully.', 'pincode' => $pincode]);
    }
}
