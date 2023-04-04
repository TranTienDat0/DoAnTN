<?php

namespace App\Services;

use App\Models\banners;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerServices
{
    public function getAllBanners()
    {

        $users = banners::orderBy('id', 'ASC')->paginate(10);
        return $users;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->status == 'Active') {
                $status = 1;
            } else {
                $status = 0;
            }
    
            $banner = new banners();
            $banner->title = $request->title;
            $banner->description = $request->description;
            $banner->slug = str::slug($request->title);
            $banner->status = $status;
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                $image->move('image', $filename);
                $banner->image = $filename;
            }
            $banner->save();
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        } 
        return $banner;
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            if ($request->status == 'Active') {
                $status = 1;
            } else {
                $status = 0;
            }
            $banner = banners::find($id);
            $banner->title = $request->title;
            $banner->description = $request->description;
            $banner->slug = str::slug($request->title);
            $banner->status = $status;
            if ($request->hasFile('image')) {
                Storage::delete('public/image/' . $banner->image);
                $image = $request->file('image');
                $filename = $image->getClientOriginalName();
                $image->move('image', $filename);
                $banner->image = $filename;
            }
            $banner->save();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $banner;
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $banner = banners::find($id)->delete();

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $banner;
    }
}
