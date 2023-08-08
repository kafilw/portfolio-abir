<?php

namespace App\Interfaces;

interface PhotosRepositoryInterface
{
    public function index();
    public function showByFilter($request);
    public function showByCategory($category);
    public function edit($id);
    public function store($request);
    public function update($request, $id);
    public function destroy($id);
    public function show($id);
    public function fkthis($request);

}
