<?php

namespace App\Http\Controllers;

use App\Services\FrontendServices;
use App\Http\Requests\LoginRequest;
use App\Models\banners;
use App\Models\blog;
use App\Models\categories;
use App\Models\products;
use App\Models\sub_categories;
use App\Models\cart;
use App\Models\order;
use App\Models\order_detail;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    protected $frontendServices;

    public function __construct(FrontendServices $frontendServices)
    {
        $this->frontendServices = $frontendServices;
    }

    public function viewLogin()
    {
        $category = categories::where('status', 1)->get();
        return view('frontend.pages.login', compact('category'));
    }
    public function login(LoginRequest $request)
    {
        $email_address = $request->email_address;
        $password = $request->password;
        $remember = $request->has('remember');
        $user = $this->frontendServices->login($email_address, $password, $remember);
        if ($user) {
            if(Auth()->user()->role == 0){
                
                return redirect()->route('home-user');
            }else{
                return redirect()->back()->with('error', 'Tài khoản không thể truy cập vào trang web này!');
            }
        } else {
            return redirect()->back()->with([
                'error' => 'Email hoặc mật khẩu không đúng.'
            ]);
        }
    }
    public function logout(){
        $this->frontendServices->logout();
        return redirect()->route('user.view-login');
    }
    public function index()
    {

        $banners = banners::where('status', 1)->limit(3)->get();
        $products = products::where('status', 1)->limit(8)->get();
        $category = categories::where('status', 1)->get();
        $carts = cart::all();
        $blogs = blog::where('status', 1)->limit(3)->get();

        return view('frontend.index', compact('banners', 'products', 'category', 'blogs', 'carts'));
    }

    public function productDetail($id)
    {
        $productDetail = products::where('id', $id)->first();
        $category = categories::where('status', 1)->get();
        $subcate = sub_categories::where('status', 1)->where('id', $productDetail->sub_categories_id)->first()->name;
        $relatedProducts = products::where('sub_categories_id', $productDetail->sub_categories_id)
            ->where('id', '!=', $id)->limit(3)->get();
        $carts = cart::all();

        return view('frontend.pages.product_detail', compact('productDetail', 'category', 'subcate', 'relatedProducts', 'carts'));
    }

    public function productList()
    {
        $products = products::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = sub_categories::select('id')->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('sub_categories_id', $cat_ids)->paginate;
            // return $products;
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'name') {
                $products = $products->where('status', '1')->orderBy('name', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);

            $products->whereBetween('price', $price);
        }

        $recent_products = products::where('status', '1')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', '1')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', '1')->paginate(6);
        }
        $category = categories::where('status', 1)->get();
        $carts = cart::all();
        return view('frontend.pages.product-lists', compact('products', 'recent_products', 'category', 'carts'));
    }

    public function productGrid()
    {
        $products = products::query();

        if (!empty($_GET['category'])) {

            $cat_ids = sub_categories::select('id')->pluck('id')->toArray();

            $products->whereIn('cat_id', $cat_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', '1')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            $products->whereBetween('price', $price);
        }

        $recent_products = products::where('status', '1')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', '1')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', '1')->paginate(9);
        }
        $category = categories::where('status', 1)->get();
        $carts = cart::all();
        return view('frontend.pages.product-grids', compact('products', 'recent_products', 'category', 'carts'));
    }

    public function productCate($cateId)
    {
        $products = categories::find($cateId)->products;
        $recent_products = products::where('status', '1')->orderBy('id', 'DESC')->limit(3)->get();

        $category = categories::where('status', 1)->get();
        $carts = cart::all();
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids', compact('products', 'recent_products', 'category', 'carts'));
        } else {
            return view('frontend.pages.product-lists', compact('products', 'recent_products', 'category', 'carts'));
        }
    }

    public function productSubCate($subCateId)
    {
        $products = sub_categories::find($subCateId)->products;
        $recent_products = products::where('status', '1')->orderBy('id', 'DESC')->limit(3)->get();

        $category = categories::where('status', 1)->get();
        $carts = cart::all();
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids', compact('products', 'recent_products', 'category', 'carts'));
        } else {
            return view('frontend.pages.product-lists', compact('products', 'recent_products', 'category', 'carts'));
        }
    }

    public function productFilter(Request $request)
    {
        $data = $request->all();
        $showURL = "";
        if (!empty($data['show'])) {
            $showURL .= '&show=' . $data['show'];
        }

        $sortByURL = '';
        if (!empty($data['sortBy'])) {
            $sortByURL .= '&sortBy=' . $data['sortBy'];
        }


        $priceRangeURL = "";
        if (!empty($data['price_range'])) {
            $priceRangeURL .= '&price=' . $data['price_range'];
        }
        if (request()->is('e-shop.loc/product-grids')) {
            return redirect()->route('product-grids',  $priceRangeURL . $showURL . $sortByURL);
        } else {
            return redirect()->route('product-lists',  $priceRangeURL . $showURL . $sortByURL);
        }
    }

    public function productSearch(Request $request)
    {
        $recent_products = products::where('status', '1')->orderBy('id', 'DESC')->limit(3)->get();
        $products = products::orwhere('name', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('price', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate('9');
        $category = categories::where('status', 1)->get();
        $carts = cart::all();
        return view('frontend.pages.product-grids', compact('products', 'recent_products', 'category', 'carts'));
    }

    public function orderIndex()
    {

        $carts = cart::all();
        $category = categories::where('status', 1)->get();
        $orders = order::where('user_id', Auth()->user()->id)->first();
        if($orders){
            $orderDetail = order_detail::orderBy('id', 'DESC')->where('order_id', $orders->id)->paginate(10);
        return view('frontend.pages.order', compact('orderDetail', 'category', 'carts'));
        }else{
            return redirect()->back()->with('error', 'Hiện tại bạn chưa có đơn hàng nào.');
        }
    }
}
