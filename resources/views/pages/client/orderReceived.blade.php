@extends('layouts.client.main')
@section('content')
    @include('components.client.alert')
    <div class="container mt-4">
        <h3 class="text-center mb-3">CHI TIẾT ĐƠN HÀNG</h3>
        <div class="row">
            <div class="col-md-7">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-danger">
                            <h5 class="mb-0 py-2">Đơn Hàng Của Bạn</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8 text-start p-0">
                                    <strong>Sản phẩm</strong>
                                </div>
                                <div class="col-4 text-end">
                                    <strong>Tổng</strong>
                                </div>
                            </div>
                            <hr class="my-1">

                            <!-- Product Details -->
                            @foreach ($order->items as $item)
                                <div class="row">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-2 p-0"><img
                                                        src="{{ asset('images/' . $item->product->image_url) }}"
                                                        alt="{{ $item->product->name }}" class="img-fluid rounded"></div>
                                                <div class="col-10 small-font">
                                                    <span class="product-name">{{ $item->product->name }}</span>
                                                    <br>
                                                    @if ($item->variant)
                                                        @foreach ($item->variant->attributes as $attribute)
                                                            <span
                                                                class="d-block text-muted"><strong>{{ $attribute->attribute->attribute_name }}</strong>:
                                                                {{ $attribute->attribute_value }}</span>
                                                        @endforeach
                                                    @endif
                                                    <br>
                                                    <span><strong>Giá:</strong>
                                                        {{ number_format($item->price, 0, ',', '.') }}₫</span>
                                                    <span>× {{ $item->quantity }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <span>{{ number_format($item->total_price, 0, ',', '.') }}₫</span>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-2">
                            @endforeach

                            <!-- Subtotal -->
                            <div class="d-flex justify-content-between pt-2 small-font">
                                <span>Tạm tính:</span>
                                <strong>{{ number_format($order->total_amount, 0, ',', '.') }}₫</strong>
                            </div>

                            <!-- Discount -->
                            @if ($order->discount_amount > 0)
                                <div class="d-flex justify-content-between pt-2 small-font">
                                    <span>Giảm giá:</span>
                                    <strong>-{{ number_format($order->discount_amount, 0, ',', '.') }}₫</strong>
                                </div>
                            @endif

                            <!-- Total -->
                            <div class="d-flex justify-content-between pt-2 small-font">
                                <strong>Tổng cộng:</strong>
                                <strong>{{ number_format($order->final_amount, 0, ',', '.') }}₫</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Confirmation Details -->
            <div class="col-md-5 ">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="pb-2">Cảm ơn bạn. Đơn hàng của bạn đã được nhận.</h5>
                        <div class="mb-2 small-font">
                            <span>Mã đơn hàng:</span>
                            <strong>{{ $order->order_code }}</strong>
                        </div>
                        <div class="mb-2 small-font">
                            <span>Trạng thái đơn hàng:</span>
                            <strong>{{ $order->status }}</strong>
                        </div>
                        <div class="mb-2 small-font">
                            <span>Ngày:</span>
                            <strong>{{ $order->created_at->format('d/m/Y') }}</strong>
                        </div>
                        <div class="mb-2 small-font">
                            <span>Email:</span>
                            <strong>{{ auth()->user()->email }}</strong>
                        </div>
                        <div class="mb-2 small-font">
                            <span>Tổng cộng:</span>
                            <strong>{{ number_format($order->final_amount, 0, ',', '.') }}₫</strong>
                        </div>
                        <div class="mb-2 small-font">
                            <span>Phương thức thanh toán:</span>
                            <strong>{{ $order->payment_method == 'Cod' ? 'Trả tiền mặt khi nhận hàng' : 'Thanh toán qua VNPAY' }}</strong>
                        </div>
                    </div>
                </div>
                <a href="{{ route('home.index') }}">
                    <div class="btn btn-danger">Tiếp tục mua hàng</div>
                </a>
            </div>
        </div>

        <!-- Payment and Shipping Address -->
        <div class="row mt-4">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0 py-2">Địa chỉ thanh toán</h5>
                    </div>
                    <div class="card-body small-font">
                        <p><strong>Họ và tên:</strong> {{ $order->full_name }}</p>
                        <p><strong>Địa chỉ:</strong> {{ $wardName }}, {{ $districtName }}, {{ $provinceName }}</p>
                        <p><strong>Địa chỉ giao hàng:</strong> {{ $order->address }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                        <p><strong>Ghi chú:</strong> {{ $order->note }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .small-font {
        font-size: 0.875em;
        /* Adjust the font size as needed */
    }
</style>
