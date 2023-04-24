<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\order;
use App\Models\order_detail;
use App\Models\payment;
use App\Models\products;
use App\Models\User;
use PDF;

class OrderController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function store(Request $request)
    {

        if (empty(Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first())) {
            return back()->with('error', 'Đã xảy ra lỗi! Giỏ hàng của bạn đang rỗng.');
        }
        $cart = new cart();
        //create payment
        if ($request->payment_method == 'paypal') {
            $payment_method = 'paypal';
            $payment_status = 'paid';
        } else {
            $payment_method = 'cod';
            $payment_status = 'Unpaid';
        }
        $payment = payment::create([
            'payment_method' => $payment_method,
            'payment_status' => $payment_status,
        ]);
        //create order
        $order = order::create([
            'status' => 'new',
            'total' => $cart->totalCartPrice(),
            'fullname' => $request->fullname,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'user_id' => Auth()->user()->id,
            'payment_id' => $payment->id,
        ]);
        //create order detail
        foreach ($cart->getAllCart() as $product) {
            $orderDetail = order_detail::create([
                'price' => $product->price,
                'quantity' => $product->quantity,
                'products_id' => $product->product_id,
                'order_id' => $order->id,
            ]);
        }
        //send mail
        cart::where('user_id', Auth()->user()->id)->delete();
        return redirect()->route('home-user')->with('success', 'Your product successfully placed in order');
    }

    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('backend.order.index')->with('orders', $orders);
    }
    public function show($id)
    {
        $order = order::find($id);
        $orderDetails = order_detail::where('order_id', $id)->get();
        return view('backend.order.show', compact('order', 'orderDetails'));
    }

    public function pdf($id)
    {
        $order = Order::find($id);
        $orderDetails = order_detail::where('order_id', $id)->get();
        $file_name = $order->id . '-' . $order->fullname . '.pdf';
        $pdf = PDF::loadview('backend.order.pdf', ['order' => $order, 'orderDetails' => $orderDetails]);
        return $pdf->download($file_name);
    }
    public function edit($id)
    {
        $order = order::find($id);
        return view('backend.order.edit', compact('order'));
    }
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $this->validate($request, [
            'status' => 'required|in:new,process,delivered,cancel'
        ]);
        $order->update([
            'status' => $request->status,
        ]);
        if ($request->status == 'delivered') {
            foreach ($order->order_detail as $orderDetail) {
                $product = products::find($orderDetail->products_id);
                $product->quantity -= $orderDetail->quantity;
                $product->save();
            }
        }
        if ($order) {
            return redirect()->route('order.index')->with('success', 'Successfully updated order');
        } else {
            return redirect()->back()->with('error', 'Error while updating order');
        }
    }

    public function delete($id){
        $order = order::find($id);
        if($order){
            $order->delete();
            return redirect()->back()->with('success', 'Bạn đã xóa đơn hàng thành công.');
        }else{
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra.');
        }
    }
}
