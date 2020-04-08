<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Role;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAll();

        return view('user.browser', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.add', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        try {
            $this->userService->store($request);
            return redirect()->route('user.index')->with('status_success', 'Tạo mới người dùng thành công!');
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->route('user.index')->with('status_error', 'Xảy ra lỗi khi thêm người dùng!');
        }
    }

    public function edit($id)
    {
        $user = $this->userService->findById($id);
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, $id)
    {

    }

    public function destroy($id)
    {
        $user = $this->userService->findById($id);
        if($user->id == Auth::user()->id){
            return redirect()->route('user.index')->with('status_danger', 'Bạn không được xóa tài khoản của mình!');
        }else{
            try{
                $user->delete();
                Log::info('Người dùng ID:'.Auth::user()->id.' đã xóa người dùng id:'.$id);
                return redirect()->route('user.index')->with('status_success', 'Xóa người dùng thành công!');
            }
            catch(Exception $e){
                Log::error($e);
                return redirect()->route('user.index')->with('status_error', 'Xảy ra lỗi khi xóa người dùng!');
            }
        }
    }
}
