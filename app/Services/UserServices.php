<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    public function getAllUsers()
    {

        $users = User::orderBy('id', 'ASC')->paginate(25);

        return $users;
    }

    public function store(Request $request)
    {
        if ($request->role == 'admin') {
            $role = 1;
        } else {
            $role = 0;
        }
        // try {
        //     DB::beginTransaction();
        $users = new User([
            'name' => $request->name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'role' => $role
        ]);
        //     DB::commit();
        // } catch (Exception $ex) {
        //     DB::rollBack();
        // }
        $users->save();
        return $users;
    }
    public function findId($id)
    {
        return User::find($id);
    }
    public function update(Request $request, $id)
    {
        if ($request->role == 'admin') {
            $role = 1;
        } else {
            $role = 0;
        }
        $users = User::find($id)->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'role' => $role
        ]);

        return $users;
    }
}
