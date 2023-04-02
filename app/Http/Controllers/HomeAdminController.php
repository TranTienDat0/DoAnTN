<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminProfile;
use App\Http\Requests\AdminProfileRequest;
use App\Services\HomeAdminServices;
use App\Models\User;

class HomeAdminController extends Controller
{
    protected $homeAdminServices;

    public function __construct(HomeAdminServices $homeAdminServices)
    {
        $this->homeAdminServices = $homeAdminServices;
    }
    public function index()
    {
        $CountCategory = $this->homeAdminServices->countCategories();
        $CountSubCategory = $this->homeAdminServices->countSubCategories();
        $CountProducts = $this->homeAdminServices->countProducts();
        $CountOrder = $this->homeAdminServices->countOrder();
        $CountAccountAdmin = $this->homeAdminServices->countAccountAdmin();
        $AdminActive = User::where('role', '1')->where('deleted_at', 'null')->count();
        $AdminInactive = $CountAccountAdmin - $AdminActive;
        $CountAccountCustom = User::count() - $CountAccountAdmin;
        $CustomActive = User::where('role', '0')->where('deleted_at', 'null')->count();
        $CustomInactive = $CountAccountCustom - $CustomActive;
        return view('backend.index', compact(
            'CountCategory',
            'CountSubCategory',
            'CountProducts',
            'CountOrder',
            'CountAccountAdmin',
            'AdminActive',
            'AdminInactive',
            'CountAccountCustom',
            'CustomActive',
            'CustomInactive'
        ));
    }
    public function profile()
    {
        $profile = Auth()->user();

        return view('backend.users.profile', compact('profile'));
    }

    public function updateProfile(AdminProfileRequest $adminProfileRequest, $id)
    {
        $result = $this->homeAdminServices->updateProfile($adminProfileRequest, $id);
        if ($result) {
            return redirect()->route('home')->with('success', 'Bạn đã cập nhật thông tin tài khoản bạn thành công.');
        } else {
            return redirect()->back()->with('error', 'Cập nhật thông tin thất bại.');
        }
    }
}
