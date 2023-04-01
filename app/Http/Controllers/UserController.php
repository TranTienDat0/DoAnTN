<?php

namespace App\Http\Controllers;

use App\Services\UserServices;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    protected $userServices;
    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }
    public function index()
    {
        $users = $this->userServices->getAllUsers();

        return view('backend.users.index', compact('users'));
    }
    public function create()
    {
        return view('backend.users.create');
    }
    public function store(UserRequest $request)
    {
        // try{
        $result = $this->userServices->store($request);
        if ($result) {
            return redirect()->route('users')->with('success', 'Thêm mới người dùng thành công.');
        } else {
            return back()->with('error', 'Thêm mới người dùng k thành công.');
        }
        // }catch(Exception $ex){
        //     throw new Exception('Error Processing Request');
        // }
    }

    public function edit($id)
    {
        $user = $this->userServices->findId($id);
        return view('backend.users.edit', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        $result = $this->userServices->update($request, $id);

        if ($result){
            return redirect()->route('user.list')->with('success', 'Sửa người dùng thành công.');
        } else {
            return back()->with('error', 'Sửa người dùng k thành công.');
        }
    }
}
