<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\products;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::all();

        return view('backend.review.index')->with('reviews', $reviews);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'rate' => 'required|numeric|min:1'
        ]);
        //dd($request->id);
        $productReview = ProductReview::create([
            'review' => $request->review,
            'rate' => $request->rate,
            'products_id' => (int)$request->id,
            'user_id' => Auth()->user()->id,
            'status' => 'active'
        ]);

        if ($productReview) {
            return redirect()->back()->with('success', 'Thank you for your feedback');
        } else {
            return redirect()->back()->with('error', 'Something went wrong! Please try again!!');
        }
    }
}
