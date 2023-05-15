<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\products;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart = cart::where('user_id', auth()->user()->id)->where('order_id', null)->get()->toArray();

        $data = [];

        // return $cart;
        $data['items'] = array_map(function ($item) use ($cart) {
            $name = products::where('id', $item['product_id'])->pluck('name');
            return [
                'name' => $name,
                'price' => $item['price'],
                'desc'  => 'Thank you for using paypal',
                'qty' => $item['quantity']
            ];
        }, $cart);

        $data['invoice_id'] = 'ORD-' . strtoupper(uniqid());
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;
       
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => session()->get('id')]);

        // return session()->get('id');
        $provider = new ExpressCheckout;

        $response = $provider->setExpressCheckout($data);

        return redirect($response['paypal_link']);
    }
}
