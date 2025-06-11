@component('mail::message')
# Cảm ơn bạn đã đặt hàng

Xin chào {{ $order->full_name }},

Đơn hàng #{{ $order->order_code }} đã được đặt thành công và chúng tôi đang xử lý.

**Phương thức thanh toán:** {{ $order->payment_method == 'Cod' ? 'Trả tiền mặt khi nhận hàng' : 'Thanh toán qua VNPAY' }}

## [Đơn hàng #{{ $order->order_code }}] ({{ $order->created_at->format('d/m/Y') }})

@component('mail::table')
| Sản phẩm | Số lượng | Giá |
| -------- |:--------:| ---:|
@foreach ($order->items as $item)
| {{ $item->product_name }}<br>
@if ($item->variant)
Dung Lượng: {{ $item->variant->attributes->where('attribute_name', 'Dung Lượng')->first()->attribute_value ?? '' }}<br>
Màu: {{ $item->variant->attributes->where('attribute_name', 'Màu')->first()->attribute_value ?? '' }}<br>
@endif
| {{ $item->quantity }} | {{ number_format($item->price, 0, ',', '.') }}₫ |
@endforeach
@endcomponent

### Tổng số phụ: {{ number_format($order->total_amount, 0, ',', '.') }}₫
### Giảm giá: -{{ number_format($order->discount_amount, 0, ',', '.') }}₫
### Tổng cộng: {{ number_format($order->final_amount, 0, ',', '.') }}₫

## Địa chỉ thanh toán
{{ $order->full_name }}<br>
{{ $order->ward }}, {{ $order->district }}, {{ $order->city }}<br>
{{ $order->address }}<br>
{{ $order->phone }}<br>

## Địa chỉ giao hàng
{{ $order->full_name }}<br>
{{ $order->ward }}, {{ $order->district }}, {{ $order->city }}<br>
{{ $order->address }}<br>
{{ $order->phone }}<br>

Thanks for using {{ config('app.name') }}!
@endcomponent
