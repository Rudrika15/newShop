<?php

namespace App\Http\Controllers;

// use App\Models\SKU;
use App\Models\Sku;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skus = Sku::paginate(10);
        return view('sku.index', compact('skus'));
    }

    public function trash()
    {
        $skus = Sku::onlyTrashed()->paginate(5);

        return view('sku.trash', compact('skus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Sku $sku)
    {
        $request->validate([
            'prefix' => 'required',
            'colorname' => 'required'
        ]);
        $input = $request->all();

        $sku->create($input);

        return redirect()->route('sku.index')->with('success', 'Sku created successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sku = SKU::find($id);

        return view('sku.edit', compact('sku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sku $sku)
    {
        $request->validate([
            'prefix' => 'required',
            'colorname' => 'required'
        ]);
        $input = $request->all();

        $sku->update($input);

        return redirect()->route('sku.index')->with('success', 'Sku updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $sku = Sku::find($id);

        $sku->delete();

        return redirect()->back()->with('success', 'Sku deleted successfully');
    }
    public function restore(string $id)
    {
        $sku = Sku::onlyTrashed($id);

        $sku->restore();

        return redirect()->back()->with('success', 'Sku restored successfully');
    }
    public function destroy(string $id)
    {
        $sku = Sku::onlyTrashed($id);

        $sku->forceDelete();

        return redirect()->back()->with('success', 'Sku permanently deleted successfully');
    }
}
