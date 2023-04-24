<?php

namespace App\Services;

use App\Models\cart;
use App\Models\products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductServices
{
    public function getAllProducts()
    {

        $products = products::orderBy('id', 'DESC')->paginate(20);
        return $products;
    }

    public function store(Request $request)
    {
        if ($request->status === 'Active') {
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
                while (file_exists("image/product/" . $image)) {
                    $image = Str::random(5) . "_" . $filename;
                }
                $file->move('image/product', $image);
            }
        }
        try {
            DB::beginTransaction();
            $products = products::create([
                'name' => $request->name,
                'price' => $request->price,
                'date_of_manufacture' => $request->date_of_manufacture,
                'expiry' => $request->expiry,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'status' => $status,
                'image' => $image,
                'sub_categories_id' => $request->sub_categories_id,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $products;
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
                while (file_exists("image/product/" . $image)) {
                    $image = Str::random(5) . "_" . $filename;
                }
                $file->move('image/product', $image);
            }
        }
        try {
            DB::beginTransaction();

            $product = products::find($id);
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'date_of_manufacture' => $request->date_of_manufacture,
                'expiry' => $request->expiry,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'status' => $status,
                'image' => $image,
                'sub_categories_id' => $request->sub_categories_id,
            ]);
            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }
        return $product;
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $product = products::find($id);

            if ($product->cart()->exists()) {
                return false;
            } else {
                $product->delete();
            }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $product;
    }
    public function deleteSelected(Request $request)
    {
        try {
            DB::beginTransaction();

            $selectedProducts = $request->input('selected', []);
            $product = products::whereIn('id', $selectedProducts);
            if ($product->cart()->exists()) {
                return false;
            } else {
                $product->delete();
            }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
        }

        return $product;
    }
    public function getProductsexpired()
    {
        $now = now();
        $products = products::orderBy('id', 'DESC')->where('expiry', '<', $now)->paginate(20);
        return $products;
    }

    public function getProductOutOfStock()
    {
        $products = products::orderBy('id', 'DESC')->where('quantity', '0')->paginate(20);
        return $products;
    }
}
