<?php

namespace App\Interfaces;


interface CommentRepositoryInterface
{
    public function store($request, $photo_id, $userID);
}
