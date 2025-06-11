<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function create(Request $request)
    {
        $title = 'Thêm giảm giá';
        $productIds = $request->input('products', []);
        $products = Product::whereIn('id', $productIds)->get();
        return view('pages.admin.discounts.create', compact('products', 'title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
            'discount_percentage' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'event_name.required' => 'Tên sự kiện không được để trống.',
            'event_name.string' => 'Tên sự kiện phải là chuỗi ký tự.',
            'event_name.max' => 'Tên sự kiện không được vượt quá 255 ký tự.',
            'product_ids.required' => 'Vui lòng chọn ít nhất một sản phẩm.',
            'product_ids.array' => 'Định dạng danh sách sản phẩm không hợp lệ.',
            'product_ids.*.exists' => 'Sản phẩm được chọn không tồn tại.',
            'discount_percentage.required' => 'Phần trăm giảm giá phải không được bỏ trống.',
            'discount_percentage.numeric' => 'Phần trăm giảm giá phải là một số.',
            'discount_amount.numeric' => 'Số tiền giảm phải là một số.',
            'start_date.required' => 'Ngày bắt đầu không được để trống.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'end_date.required' => 'Ngày kết thúc không được để trống.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
        ]);

        $existingDiscounts = Discount::whereIn('product_id', $validated['product_ids'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                    });
            })
            ->pluck('product_id')
            ->toArray();

        if (!empty($existingDiscounts)) {
            $existingProductNames = Product::whereIn('id', $existingDiscounts)->pluck('name')->toArray();
            return redirect()->back()->withErrors(['discount' => 'Sản phẩm ' . implode(', ', $existingProductNames) . ' đã có giảm giá đang hoạt động trong khoảng thời gian này.']);
        }

        foreach ($validated['product_ids'] as $productId) {
            Discount::create([
                'event_name' => $validated['event_name'],
                'product_id' => $productId,
                'discount_percentage' => $validated['discount_percentage'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ]);
        }

        return redirect()->route('discounts.index')->with('success', 'Giảm giá được tạo thành công.');
    }
    public function index()
    {
        $title = 'Danh sách giảm giá';
        $discounts = Discount::with('product')->paginate(10);
        return view('pages.admin.discounts.index', compact('discounts', 'title'));
    }
    public function edit($id)
    {
        $title = 'Sửa giảm giá';
        $discounts = Discount::with('product')->paginate(10);
        return view('pages.admin.discounts.edit', compact('discounts', 'title'));
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        Discount::whereIn('id', $ids)->delete();

        return response()->json(['success' => true]);
    }
}
