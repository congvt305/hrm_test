<?php


namespace App\Repositories;


use App\User;

class UserRepository extends EloquentImpl
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->user->with('roles')->get();
    }

    public function storeOrUpdate($obj)
    {
        $obj->save();
    }

    public function delete($obj)
    {
        return $obj->delete();
    }

    public function findById($id)
    {
        return $this->user->findOrFail($id);
    }

    public function changePassword($user) {
        $user->save();
    }
}
