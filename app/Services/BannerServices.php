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
        if ($request->status == 'Active') {
            $status = 1;
        } else {
            $status = 0;
        }
        $image = $request->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if (strcasecmp($extension, 'jpg') || strcasecmp($extension, 'png') || strcasecmp($extension, 'jepg')) {
                $image = Str::random(5) . "_" . $filename;
                while (file_exists("image/banner/" . $image)) {
                    $image = Str::random(5) . "_" . $filename;
                }
                $file->move('image/banner', $image);
            }
        }
        try {
            DB::beginTransaction();

            $banner = banners::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'status' => $status,
                'image' => $image,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $banner;
    }

    public function update(Request $request, $id)
    {
        if ($request->status == 'Active') {
            $status = 1;
        } else {
            $status = 0;
        }
        $image = $request->image;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();

            if (strcasecmp($extension, 'jpg') || strcasecmp($extension, 'png') || strcasecmp($extension, 'jepg')) {
                $image = Str::random(5) . "_" . $filename;
                while (file_exists("image/banner/" . $image)) {
                    $image = Str::random(5) . "_" . $filename;
                }
                $file->move('image/banner', $image);
            }
        }
        try {
            DB::beginTransaction();

            $banner = banners::find($id);
            $banner->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'description' => $request->description,
                'status' => $status,
                'image' => $image,
            ]);

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
