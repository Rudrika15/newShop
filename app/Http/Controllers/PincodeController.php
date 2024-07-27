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
        $pincodes = Pincode::paginate(50);
        return view('pincode.index', compact('pincodes'));
    }

    // public function trash()
    // {
    //     $sliders = Slider::onlyTrashed()->paginate(5);

    //     return view('slider.trash', compact('sliders'));
    // }

    // /**
    //  * Show the form for creating a new resource.
    //  */
    // public function create()
    // {
    //     return view('slider.create');
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'sliderName' => 'required|string|max:255',
    //         'sliderImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    //     ]);

    //     $sliders = new Slider();
    //     $sliders->sliderName = $request->sliderName;

    //     if ($request->hasFile('sliderImage')) {
    //         $image = $request->file('sliderImage');
    //         $imageName = time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('images/slider'), $imageName);
    //         $sliders->sliderImage = $imageName;
    //     }

    //     $sliders->save();

    //     return redirect()->route('slider.index')->with('success', 'Slider created successfully');
    // }

    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     //
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     $sliders = Slider::find($id);

    //     return view('slider.edit', compact('sliders'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'sliderName' => 'required|string|max:255',
    //         'sliderImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    //     ]);

    //     $sliders = Slider::find($id);
    //     if (!$sliders) {
    //         return redirect()->route('slider.index')->with('error', 'Slider not found');
    //     }

    //     $sliders->sliderName = $request->sliderName;

    //     if ($request->hasFile('sliderImage')) {
    //         // Delete the old image if exists
    //         if ($sliders->sliderImage && file_exists(public_path('images/slider/' . $sliders->sliderImage))) {
    //             unlink(public_path('images/slider/' . $sliders->sliderImage));
    //         }

    //         $image = $request->file('sliderImage');
    //         $imageName = time() . '.' . $image->getClientOriginalExtension();
    //         $image->move(public_path('images/slider'), $imageName);
    //         $sliders->sliderImage = $imageName;
    //     }

    //     $sliders->save();

    //     return redirect()->route('slider.index')->with('success', 'Slider updated successfully');
    // }


    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function delete(string $id)
    // {
    //     $sliders = Slider::find($id);

    //     $sliders->delete();

    //     return redirect()->back()->with('success', 'Slider deleted successfully');
    // }
    // public function restore(string $id)
    // {
    //     $sliders = Slider::onlyTrashed()->where('id', $id)->first();

    //     $sliders->restore();

    //     return redirect()->back()->with('success', 'Slider restored successfully');
    // }
    // public function destroy(string $id)
    // {
    //     $sliders = Slider::onlyTrashed()->where('id', $id)->first();

    //     $sliders->forceDelete();

    //     return redirect()->back()->with('success', 'Slider permanently deleted successfully');
    // }
}
