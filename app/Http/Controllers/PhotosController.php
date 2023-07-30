<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photos;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('photos.index')
            ->with('photos', Photos::orderBy('rank', 'DESC')->get());
    }

    public function showByCategory($category)
    {
        $photos = Photos::where('category', $category)->get();
        return view('photos.showByCategory', compact('photos', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('photos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'category' => 'required',
            'rank' => 'required|in:wedding,product,outdoor',
            'photo' => 'required|mimes:png,jpg,jpeg,cr2',
        ]);

        $newImageName = uniqid() . '-' . $request->category . '.' .
        $request->photo->extension();

        $request->photo->move(public_path('images'), $newImageName);

        Photos::create([
            'category' => $request->input('category'),
            'rank' => $request->input('rank'),
            'name' => $newImageName,
        ]);

        return redirect('/photos')->with('message', 'ADDED!!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
