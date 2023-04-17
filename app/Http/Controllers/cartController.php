<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\cart;
use App\Models\categories;
use Illuminate\Http\Request;

class cartController extends Controller
{
    protected $product = null;
    public function __construct(products $product)
    {
        $this->product = $product;
    }

    public function index()
    {
        $carts = cart::all();
        $category = categories::where('status', 1)->get();
        return view('frontend.pages.cart', compact('carts', 'category'));
    }

    public function addToCart(Request $request)
    {
        // dd($request->all());
        if (empty($request->id)) {
            return back()->with('error', 'Invalid Products');
        }

        $product = products::where('id', $request->id)->first();
        // return $product;
        if (empty($product)) {
            
            return back()->with('error', 'Invalid Products');
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if ($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price + $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->product->quantity < $already_cart->quantity || $already_cart->product->quantity <= 0) return back()->with('error', 'Stock not sufficient!.');
            $already_cart->save();
        } else {

            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = $product->price;
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;
            if ($cart->product->quantity < $cart->quantity || $cart->product->quantity <= 0) return back()->with('error', 'Stock not sufficient!.');
            $cart->save();
            //$wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }
        return back()->with('success', 'Product successfully added to cart');
    }

    public function cartUpdate(Request $request){
        if($request->quant){
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k=>$quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if($quant > 0 && $cart) {

                    if($cart->product->quantity < $quant){
                        return back()->with('error','Out of quantity');
                    }
                    $cart->quantity = ($cart->product->quantity > $quant) ? $quant  : $cart->product->quantity;
                    // return $cart;
                    
                    if ($cart->product->quantity <=0) continue;
                    $after_price=$cart->product->price;
                    $cart->amount = $after_price * $quant;
                    $cart->save();
                    $success = 'Cart successfully updated!';
                }else{
                    $error[] = 'Cart Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        }else{
            return back()->with('Cart Invalid!');
        }    
    }
}
