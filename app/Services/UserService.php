<?php


namespace App\Services;


use App\Repositories\UserRepository;
use App\User;
use Illuminate\Support\Facades\Hash;;

class UserService extends ServiceImpl
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function store($request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $this->userRepository->storeOrUpdate($user);
        $user->syncRoles($request->role);
    }

    public function update($request, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        $user = $this->userRepository->findById($id);
        $this->userRepository->delete($user);
    }

    public function findById($id)
    {
        return $this->userRepository->findById($id);
    }
}
