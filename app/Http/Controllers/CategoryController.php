<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(5);
// return $categories= Category::with('children')->get();
        return view('category.index', compact('categories'));
    }

    //trashed
    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(5);

        return view('category.trash', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Retrieve all parent categories
        $categories = Category::where('is_parent', true)->get();

        return view('category.create', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'categoryname' => 'required|string|max:255',
            'is_parent' => 'boolean',
            'parent' => 'nullable|exists:categories,id',
        ]);

        // Create a new category instance
        $newCategory = new Category();
        $newCategory->categoryname = $request->categoryname;
        $newCategory->is_parent = $request->has('is_parent');

        // Assign parent category if 'is_parent' is false and 'parent' is provided
        if (!$newCategory->is_parent && $request->parent) {
            $newCategory->parent = $request->parent;
        }

        // Save the new category
        $newCategory->save();

        return redirect()->route('category.index')->with('success', 'Category Created Successfully');
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
    public function edit($id)
    {
        // Retrieve the category to be edited
        $category = Category::findOrFail($id);
        // Retrieve all parent categories except the current category
        $categories = Category::where('is_parent', true)->where('id', '!=', $id)->get();

        return view('category.edit', compact('category', 'categories'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'categoryname' => 'required|string|max:255',
            'is_parent' => 'boolean',
            'parent' => 'nullable|exists:categories,id',
        ]);

        // Retrieve the category to be updated
        $category = Category::findOrFail($id);
        $category->categoryname = $request->categoryname;
        $category->is_parent = $request->has('is_parent');

        // Assign parent category if 'is_parent' is false and 'parent' is provided
        if (!$category->is_parent && $request->parent) {
            $category->parent = $request->parent;
        } else {
            $category->parent = null;
        }

        // Save the updated category
        $category->save();

        return redirect()->route('category.index')->with('success', 'Category Updated Successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $category = Category::find($id);

        $category->delete();

        return redirect()->back()->with('success', 'Category Deleted Successfully');
    }
    public function restore(string $id)
    {
        $category = Category::withTrashed()->find($id);

        $category->restore();

        return redirect()->route('category.trash')->with('success', 'Category Restored Successfully');
    }
    public function destroy(string $id)
    {
        $category = Category::withTrashed()->find($id);

        $category->forceDelete();

        return redirect()->route('category.trash')->with('success', 'Category Deleted Permanently Successfully');
    }
}
