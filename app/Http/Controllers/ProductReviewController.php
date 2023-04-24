<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\products;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index()
    {
        $reviews = ProductReview::orderBy('id', 'DESC')->paginate(20);

        return view('backend.review.index')->with('reviews', $reviews);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'rate' => 'required|numeric|min:1'
            ],
            [
                'rate.required' => 'Vui lòng chọn số sao đánh giá.'
            ]
        );
        $productReview = ProductReview::create([
            'review' => $request->review,
            'rate' => $request->rate,
            'products_id' => (int)$request->id,
            'user_id' => Auth()->user()->id,
            'status' => 'active'
        ]);

        if ($productReview) {
            return redirect()->back()->with('success', 'Cảm ơn phản hồi của bạn.');
        } else {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi! Vui lòng thử lại!!');
        }
    }
    public function edit($id)
    {
        $review = ProductReview::find($id);
        return view('backend.review.edit', compact('review'));
    }
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'review' => 'required|string|max:255'
            ],
            [
                'review.required' => 'Nội dung đánh giá không được để trống.'
            ]
        );
        $review = ProductReview::find($id);
        $review->update([
            'review' => $request->review,
            'status' => $request->status,
        ]);
        if ($review) {
            return redirect()->route('products.review')->with('success', 'Sửa đánh giá thành công.');
        }else{
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra! Vui lòng thử lại!!');
        }
    }
    public function delete($id)
    {
        $review = ProductReview::find($id);
        if($review){
            $review->delete();
            return redirect()->back()->with('success', 'Xóa thành công đánh giá.');
        }else{
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra! Vui lòng thử lại!!');
        }
    }
}
