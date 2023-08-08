<?php

namespace App\Repositories;

use App\Interfaces\PhotosRepositoryInterface;
use App\Models\Photos;

class PhotosRepository implements PhotosRepositoryInterface
{
    public function index()
    {
        return Photos::orderBy('rank', 'ASC')->get();
    }

    public function showByFilter($request)
    {
        //dynamic query
    }

    public function showByCategory($category)
    {
        return Photos::where('category', $category)->get();
    }

    public function edit($id)
    {
        return Photos::find($id);
    }

    public function store($request)
    {
        //$photo = new Photos();
        return Photos::create([
            'category' => $request->category,
            'rank' => $request->rank,
            'name' => $request->name,
            'user_id' => $request->user_id,
        ]);
        //$photo->save();
        //return $photo;
    }

    public function update($request, $id)
    {
        return Photos::where('id', $id)->update([
            'category' => $request->category,
            'rank' => $request->rank,
        ]);
    }
    public function destroy($id)
    {
        return Photos::find($id)->delete();
    }
    public function show($id)
    {
        $photo = Photos::find($id);

        if (is_null($photo)) {
            return null;
        }

        $user_name = $photo->user->name;

        $photoWithUserName = (object) [
            'id' => $photo->id,
            'name' => $photo->name,
            'category' => $photo->category,
            'rank' => $photo->rank,
            'created_at' => $photo->created_at,
            'updated_at' => $photo->updated_at,
            'author' => $user_name,
        ];

        return $photoWithUserName;
    }
    public function fkthis($request)
    {

    }
}
