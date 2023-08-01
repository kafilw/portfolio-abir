<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Photos;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('photos.index')
            ->with('photos', Photos::orderBy('rank', 'ASC')->get());
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
            'category' => 'required|in:wedding,product,outdoor',
            'rank' => 'required',
            'photo' => 'required|mimes:png,jpg,jpeg',
        ]);

        $newImageName = uniqid() . '-' . $request->category . '.' .
        $request->photo->extension();

        $request->photo->move(public_path('images'), $newImageName);

        Photos::create([
            'category' => $request->input('category'),
            'rank' => $request->input('rank'),
            'name' => $newImageName,
        ]);

        return redirect('/photos/create')->with('message', 'ADDED!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Not needed, used showByCategory instead
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //dd(Photos::where('id', $id)->first()->toArray());
        return view('photos.edit')
            ->with('photo', Photos::where('id', $id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        Photos::where('id', $id)->update([
            'category' => $request->input('category'),
            'rank' => $request->input('rank'),
        ]);
        return redirect('/photos')
            ->with('message', 'Photo with ID '.$id.' UPDATED!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = Photos::where('id', $id)->first();
        if (Storage::disk('public/images')->exists($photo->name)) {
            Storage::disk('public/images')->delete($photo->name);
            //return "File $photo->name has been deleted.";
        }

        //return "File $photo->name not found.";
        $photo->delete();
        return redirect('/photos')
            ->with('message', 'Photo with ID '.$id.' DELETED!!');
    }
}
