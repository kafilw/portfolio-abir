<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Photos;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PhotosRepository;

class PhotosController extends Controller
{
    protected $photosRepository;

    public function __construct(PhotosRepository $photosRepository)
    {
        $this->photosRepository = $photosRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = $this->photosRepository->index();
        return response()->json([
            'photos' => $photos,
        ]);
    }

    public function showByFilter(Request $request)
    {
        $photos = $this->photosRepository->showByFilter($request);

        return response()->json([
            'photos' => $photos,
        ]);
    }

    public function showByCategory($category)
    {
        $photos = $this->photosRepository->showByCategory($category);
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
        $request->validate([
            'category' => 'required|in:wedding,product,outdoor',
            'rank' => 'required',
            'photo' => 'required',
        ]);

        $newImageName = url('/') . '/images' . '/' .uniqid() . '-' . $request->category . '.' .
        $request->photo->extension();
        $request->photo->move(public_path('images'), $newImageName);
        $user = Auth::user();
        $userID = $user->id;
        $request->merge([
            'name' => $newImageName,
            'user_id' => $userID,
        ]);

        $photo = $this->photosRepository->store($request);

        return response()->json([
            'message' => 'Photo created successfully',
            'photo' => $photo
        ]);
        //return redirect('/photos/create')->with('message', 'ADDED!!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $photoData = $this->photosRepository->show($id);

        if ($photoData === null) {
            return response()->json([
                'message' => 'Photo not found',
            ], 404);
        }

        return response()->json($photoData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $photo = $this->photosRepository->show($id);
        return response()->json([
            'photo' => $photo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $photo = $this->photosRepository->show($id);
        if(is_null($photo)) {
            return response()->json([
                'message' => 'Photo not found',
            ]);
        }
        //dd($request);
        $this->photosRepository->update($request, $id);

        return response()->json([
            'message' => 'Photo updated successfully',
            'photo' => [
                'id' => $id,
                'category' => $request->input('category'),
                'rank' => $request->input('rank'),
            ]
        ]);

        // return redirect('/photos')
        //     ->with('message', 'Photo with ID '.$id.' UPDATED!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = $this->photosRepository->show($id);
        if(is_null($photo)) {
            return response()->json([
                'message' => 'Photo not found',
            ]);
        }
        $fullUrl = $photo->name;

        $fileName = str_replace(url('/'), '', $fullUrl);
        if (Storage::disk('public')->exists('images/' . $fileName)) {
            Storage::disk('public')->delete('images/' . $fileName);
        }

        $deleted = $this->photosRepository->destroy($id);
        return response()->json([
            'message' => 'Photo deleted successfully',
            'deleted' => $deleted,
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
