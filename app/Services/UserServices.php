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

        $users = User::create([
            'name' => $request->name,
            'email_address' => $request->email_address,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'role' => $role,
        ]);

        return $users;
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

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $user = User::find($id)->delete();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $user;
    }
}
