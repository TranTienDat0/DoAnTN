<?php

namespace App\Services;

use App\Models\categories;
use App\Models\order;
use App\Models\sub_categories;
use App\Models\products;
use App\Models\User;

class HomeAdminServices
{
    public function countCategories()
    {
        $conutCategories = Categories::count();

        if ($conutCategories) {
            return $conutCategories;
        }
        return 0;
    }
    public function countSubCategories()
    {
        $conutSubCategories = Sub_categories::count();

        if ($conutSubCategories) {
            return $conutSubCategories;
        }
        return 0;
    }
    public function countProducts()
    {
        $conutProducts = products::count();

        if ($conutProducts) {
            return $conutProducts;
        }
        return 0;
    }

    public function countOrder()
    {
        $countOrder = order::count();

        if ($countOrder) {
            return $countOrder;
        }
        return 0;
    }

    public function countAccountAdmin()
    {
        $countAdmin = User::where('role', '1')->count();
        if ($countAdmin) {
            return $countAdmin;
        }
        return 0;
    }
}
