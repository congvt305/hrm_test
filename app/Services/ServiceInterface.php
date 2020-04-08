<?php


namespace App\Services;


interface ServiceInterface
{
    public function getAll();

    public function store($request);

    public function update($request, $id);

    public function delete($id);

    public function findById($id);
}
