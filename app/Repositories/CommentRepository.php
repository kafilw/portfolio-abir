<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;


class CommentRepository implements CommentRepositoryInterface
{
    public function store($request, $photo_id, $userID)
    {
        return Comment::create([
            'comment' => $request->comment,
            'user_id' => $userID,
            'photo_id' => $photo_id,
        ]);
    }
}
