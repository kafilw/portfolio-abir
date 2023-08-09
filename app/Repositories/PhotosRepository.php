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
        $categories = $request->query('categories');
        $user_id = $request->query('user_id');

        return Photos::orderBy('id', 'ASC')
            ->when($categories, function ($query, $categories) {
                return $query->whereIn('category', $categories);
            })
            ->when($user_id, function ($query, $user_id) {
                return $query->where('user_id', $user_id);
            })
            ->get();
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
        //$photo = Photos::find($id);
        $photo = Photos::with('comment.user')->find($id);


        if (is_null($photo)) {
            return null;
        }
        return $photo;
        // $user_name = $photo->user->name;
        // $comment = $photo->comment;
        // //$comment_id = $comment->id;

        // $photoDetail = (object) [
        //     'id' => $photo->id,
        //     'name' => $photo->name,
        //     'category' => $photo->category,
        //     'rank' => $photo->rank,
        //     'created_at' => $photo->created_at,
        //     'updated_at' => $photo->updated_at,
        //     'author' => $user_name,
        //     'comment' => $comment,
        // ];

        // return $photoDetail;
    }
    public function fkthis($request)
    {

    }
}
