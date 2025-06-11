<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class OrdersContrller extends Controller
{
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
        return view('pages.client.orderReceived', compact('order', 'title', 'provinceName', 'districtName', 'wardName'));
    }
    public function myOrders()
    {      $title = 'Đơn hàng của tôi';
        $orders = Order::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('pages.client.myOrders', compact('orders','title'));
    }
}
