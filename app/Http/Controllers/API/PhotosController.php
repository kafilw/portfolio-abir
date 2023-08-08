<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Photos;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photos::orderBy('rank', 'ASC')->get();
        return response()->json([
            'photos' => $photos,
        ]);
    }

    public function showByFilter(Request $request)
    {
        $categories = $request->query('categories');
        $user_id = $request->query('user_id');

        $photos = Photos::orderBy('rank', 'ASC');
        //dd($categories);

        if ($categories) {
            //$categoriesArray = explode('&categories=', $categories); // Convert comma-separated string to array
            $photos = $photos->whereIn('category', $categories);
        }

        if ($user_id) {
            $photos = $photos->where('user_id', $user_id);
        }

        $photos = $photos->get();
        //dd($categories);

        return response()->json([
            'photos' => $photos,
        ]);
    }




    public function showByCategory($category)
    {
        $photos = Photos::where('category', $category)->get();
        return response()->json([
            'photos' => $photos,
            'category' => $category,
        ]);
        //return view('photos.showByCategory', compact('photos', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //return view('photos.create');
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
            'photo' => 'required',
        ]);
        //dd($request);

        $newImageName = url('/') . '/images' . '/' .uniqid() . '-' . $request->category . '.' .
        $request->photo->extension();

        $request->photo->move(public_path('images'), $newImageName);
        $user = Auth::user();
        $userID = $user->id;

        Photos::create([
            'category' => $request->input('category'),
            'rank' => $request->input('rank'),
            'name' => $newImageName,
            'user_id' => $userID,
        ]);

        return response()->json([
            'message' => 'Photo created successfully',
            'photo' => [
                'category' => $request->input('category'),
                'rank' => $request->input('rank'),
                'name' => $newImageName,
                'user_id' => $userID,
            ]
        ], 201);
        //return redirect('/photos/create')->with('message', 'ADDED!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $photo = Photos::where('id', $id)->first();
        return response()->json([
            'photo' => $photo,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //dd(Photos::where('id', $id)->first()->toArray());
        $photo = Photos::where('id', $id)->first();
        return response()->json([
            'photo' => $photo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->input('category'));
        if(Photos::where('id', $id)->update([
            'category' => $request->category,
            'rank' => $request->rank,
        ])) {
            return response()->json([
                'message' => 'Photo updated successfully',
                'photo' => [
                    'id' => $id,
                    'category' => $request->input('category'),
                    'rank' => $request->input('rank'),
                ]
            ]);
        }
        return response()->json([
            'message' => 'Photo not updated',
        ]);

        // return redirect('/photos')
        //     ->with('message', 'Photo with ID '.$id.' UPDATED!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = Photos::where('id', $id)->first();
        // Get the full URL of the file using the 'public' disk
        $fullUrl = $photo->name;

        // Extract the file name from the URL by stripping the base URL
        $fileName = str_replace(url('/'), '', $fullUrl);
        if (Storage::disk('public')->exists('images/' . $fileName)) {
            Storage::disk('public')->delete('images/' . $fileName);
            //return "File $photo->name has been deleted.";
        }

        //return "File $photo->name not found.";
        $photo->delete();
        return response()->json([
            'message' => 'Photo deleted successfully',
            'photo' => $photo,
        ]);
        // return redirect('/photos')
        //     ->with('message', 'Photo with ID '.$id.' DELETED!!');
    }

    public function fkthis(Request $request)
    {
        $user = Auth::user();
        dd($user->id);
        // Access user's token
        // $token = $user->currentAccessToken();
    }
}
