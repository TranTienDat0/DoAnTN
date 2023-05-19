<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Cart;

class CouponController extends Controller
{

    public function index()
    {
        $coupons = Coupon::orderBy('id', 'DESC')->paginate('10');
        return view('backend.coupon.index', compact('coupons'));
    }


    public function create()
    {
        return view('backend.coupon.create');
    }
    
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'code' => 'string|required',
                'type' => 'required|in:fixed,percent',
                'value' => 'required|numeric',
                'status' => 'required|in:active,inactive'
            ],
            [
                'code' => 'Vui lòng nhập mã code giảm giá.',
                'value' => 'Vui lòng nhập tỷ lệ phần trăm giảm giá.',
            ]
        );
        $data = $request->all();
        $status = Coupon::create($data);
        if ($status) {
            return redirect()->route('coupon.index')->with('success', 'Thêm mới thành công');
        } else {
            return redirect()->route('coupon.index')->with('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            return view('backend.coupon.edit')->with('coupon', $coupon);
        } else {
            return view('backend.coupon.index')->with('error', 'Coupon not found');
        }
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        $this->validate($request, [
            'code' => 'string|required',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric',
            'status' => 'required|in:active,inactive'
        ]);
        $data = $request->all();

        $status = $coupon->fill($data)->save();
        if ($status) {
            request()->session()->flash('success', 'Coupon Successfully updated');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
        return redirect()->route('coupon.index');
    }


    public function delete($id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $status = $coupon->delete();
            if ($status) {
                request()->session()->flash('success', 'Coupon successfully deleted');
            } else {
                request()->session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('coupon.index');
        } else {
            request()->session()->flash('error', 'Coupon not found');
            return redirect()->back();
        }
    }

    public function couponStore(Request $request)
    {
        // return $request->all();
        $coupon = Coupon::where('code', $request->code)->first();
        // dd($coupon);
        if (!$coupon) {
            request()->session()->flash('error', 'Invalid coupon code, Please try again');
            return back();
        }
        if ($coupon) {
            $total_price = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->sum('price');
            // dd($total_price);
            session()->put('coupon', [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'value' => $coupon->discount($total_price)
            ]);
            request()->session()->flash('success', 'Coupon successfully applied');
            return redirect()->back();
        }
    }
}
