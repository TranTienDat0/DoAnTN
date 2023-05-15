<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\order;
use App\Models\order_detail;
use App\Models\payment;
use App\Models\products;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
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
        $user = $order->user;
        $orderDetails = order_detail::where('order_id', $order->id)->get();
        if(request('payment_method')=='paypal'){
            return redirect()->route('payment', compact('id', $order->id));
        }
        Mail::send('frontend.mail.order-confirmation', compact('user', 'order', 'orderDetails'), function ($message) use ($user) {
            $message->to($user->email_address, $user->name);
            $message->subject('Order Confirmation');
        });

        cart::where('user_id', Auth()->user()->id)->delete();
        return redirect()->route('home-user')->with('success', 'Bạn đã đặt hành thành công.');
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

    public function delete($id)
    {
        $order = order::find($id);
        if ($order && $order->status != 'delivered') {
            $order->delete();
            return redirect()->back()->with('success', 'Bạn đã xóa đơn hàng thành công.');
        } else {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra. Không thể xóa đơn hàng này.');
        }
    }
    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        // dd($year);
        $items = Order::whereYear('created_at', $year)->where('status', 'delivered')->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        // dd($items);
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->sum('total');
                // dd($amount);
                $m = intval($month);
                return $m;
                // dd($m);
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
