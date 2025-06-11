<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Hóa đơn | Admin KhanhUD Mobile';
        $search = $request->input('search');
        $status = $request->input('status');
    
        $orders = Order::query()
            ->when($search, function ($query, $search) {
                $query->where('order_code', 'like', '%' . $search . '%')
                    ->orWhere('full_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc') // Sắp xếp theo ngày tạo mới nhất
            ->paginate(10);
    
        return view('pages.admin.orders.index', compact('orders', 'title'));
    }
    

    public function show($id)
    {
        $order = Order::with('items.product', 'items.variant.attributes.attribute')->findOrFail($id);
    
        // Lấy tên tỉnh/thành phố, quận/huyện, và phường/xã từ API
        $province = Http::get("https://esgoo.net/api-tinhthanh/1/0.htm")->json();
        $district = Http::get("https://esgoo.net/api-tinhthanh/2/{$order->city}.htm")->json();
        $ward = Http::get("https://esgoo.net/api-tinhthanh/3/{$order->district}.htm")->json();
    
        // Tìm tên tỉnh/thành phố
        $provinceName = collect($province['data'])->firstWhere('id', $order->city)['full_name'] ?? 'N/A';
        // Tìm tên quận/huyện
        $districtName = collect($district['data'])->firstWhere('id', $order->district)['full_name'] ?? 'N/A';
        // Tìm tên phường/xã
        $wardName = collect($ward['data'])->firstWhere('id', $order->ward)['full_name'] ?? 'N/A';
    
        $title = 'Thanh toán hóa đơn';
        return view('pages.admin.orders.detail', compact('order', 'title', 'provinceName', 'districtName', 'wardName'));
    }

    public function edit($id)
    {
        $title = '';
        $order = Order::findOrFail($id);
        return view('pages.admin.orders.edit', compact('order','title'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $newStatus = $request->input('status');
        $currentStatus = $order->status;

        // Logic thay đổi trạng thái
        $validTransitions = [
            'pending' => ['processing', 'canceled'],
            'processing' => ['completed', 'canceled'],
            'completed' => [], // Không thể thay đổi
            'canceled' => []  // Không thể thay đổi
        ];

        if (!in_array($newStatus, $validTransitions[$currentStatus])) {
            return redirect()->route('admin.orders.index')->with('error', 'Thay đổi trạng thái không hợp lệ.');
        }

        $order->status = $newStatus;
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }

}
