<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $sliders = Slider::where('status', 'Active')->orderBy('created_at', 'desc')->paginate(10);
        return view('slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catalogs = Catalog::all();
        return view('slider.create', compact('catalogs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        
            'sliderImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $validator->validate();

        $sliderImage  =  $request->sliderImage;
        $catalogId = $request->catalogId;

        $slider = new Slider();
        $slider->catalogid = $catalogId;
        $slider->title =$request->title;
        if ($request->hasFile('sliderImage')) {
            $image = $request->file('sliderImage');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('slider'), $imageName);
            $sliderImage = $imageName;
        }

        $slider->image = $sliderImage;
        $slider->save();
        return redirect()->route('slider.index')->with('success', 'Slider created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
    }
    public function delete($id)
    {
        $slider = Slider::find($id);
        $slider->status = "Deleted";
        $slider->save();
        return redirect()->route('slider.index')->with('success', 'Slider deleted successfully');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }
    public function trash()
    {
        $sliders = Slider::where('status', 'Deleted')->paginate(5);
        return view('slider.trash', compact('sliders'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public  function restore($id)
    {
        $slider = Slider::find($id);
        $slider->status = "Active";
        $slider->save();
        return redirect()->route('slider.trash')->with('success', 'Slider restored successfully');
    }
    public function destroy($id)
    {
        //
        $slider = Slider::find($id);
        $slider->delete();
        return redirect()->route('slider.index')->with('success', 'Slider deleted successfully');
    }
}
