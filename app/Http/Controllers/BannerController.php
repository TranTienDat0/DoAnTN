<?php

namespace App\Http\Controllers;

use App\Services\BannerServices;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $bannerServices;
    public function __construct(BannerServices $bannerServices)
    {
        $this->bannerServices = $bannerServices;
    }

    public function index(){
        $banners = $this->bannerServices->getAllBanners();

        return view('backend.banner.index', compact('banners'));
    }
}
