<?php

namespace App\Http\Controllers;

use App\Models\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    //
    public function index()
    {
        $version = Version::orderBy('id', 'desc')->get();
        return view ('version.index', compact('version'));
    }
    public function create()
    {
        return view ('version.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'version' => 'required',
            'url' => 'required'

        ], [
            'version.required' => 'Version is required',
            'url.required' => 'Url is required',
        ]);

      $version = new Version();
      $version->version = $request->version;
      $version->url = $request->url;
      $version->major =$request->major;
      $version->save();
        
        return redirect()->back()->with('success', 'Version created successfully.');
        
    }

    public function edit($id)
    {
        $version = Version::find($id);
        return view ('version.edit', compact('version'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'version' => 'required',
            'url' => 'required'
        ], [
            'version.required' => 'Version is required',
            'url.required' => 'Url is required',
        ]);

        $version = Version::find($id);
        $version->version = $request->version;
        $version->url = $request->url;
        $version->save();
        return redirect()->back()->with('success', 'Version updated successfully');
    }

    public function destroy($id)
    {
        $version = Version::find($id);
        $version->delete();
        return redirect()->back()->with('success', 'Version deleted successfully');
    }
}
