@extends ('layouts.client.main')
@section('content')
    @include('components.client.alert')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-7 mb-3">
                @if ($cart && $cart->items->count() > 0)
                    <div class="table-responsive">
                        <form id="updateCartForm" action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Tạm tính</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cart->items as $item)
                                        <tr>
                                            <td>
                                                <div class="col-2 d-flex align-items-center">
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm rounded-circle"
                                                        onclick="removeItem({{ $item->id }})">&times;</button>
                                                </div>
                                            </td>
                                            <td class="col-6 align-content-center">
                                                <div class="row">
                                                    <div class="col-3 p-0">
                                                        <img src="{{ asset('images/' . $item->product->image_url) }}"
                                                            alt="{{ $item->product->name }}" class="img-fluid rounded">
                                                    </div>
                                                    <div class="col-8">
                                                        <span class="d-block">{{ $item->product->name }}</span>
                                                        @if ($item->variant)
                                                            @foreach ($item->variant->attributes as $attribute)
                                                                <span class="d-block text-muted">
                                                                    {{ $attribute->attribute->attribute_name }}:
                                                                    {{ $attribute->attribute_value }}</span>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col-2 align-content-center">
                                                {{ number_format($item->price, 0, ',', '.') }}₫
                                            </td>
                                            <td class="col-2 align-content-center">
                                                <input type="number" name="items[{{ $item->id }}]" class="form-control"
                                                    value="{{ $item->quantity }}" min="1">
                                            </td>
                                            <td class="col-2 align-content-center">
                                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('productsClient.index') }}" class="btn btn-outline-danger">&larr; Tiếp
                                    tục xem sản phẩm</a>
                                <button type="submit" class="btn btn-danger">Cập nhật giỏ hàng</button>
                            </div>
                        </form>
                    </div>
                @else
                    <p>Giỏ hàng của bạn hiện đang trống.</p>
                    <a href="{{ route('home.index') }}">
                        <div class="btn btn-danger">Quay về trang chủ</div>
                    </a>
                @endif

            </div>
            <div class="col-md-5">
                @if ($cart && $cart->items->count() > 0)
                    <div class="p-3 bg-light border rounded">
                        <h5 class="border-bottom pb-2">Cộng giỏ hàng</h5>
                        <div class="d-flex justify-content-between">
                            <span>Tạm tính</span>
                            <span>{{ number_format($cart->items->sum(function ($item) {return $item->price * $item->quantity;}),0,',','.') }}₫</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Mã giảm giá (GIAM20%)</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2">
                            <strong>Tổng</strong>
                            <strong>{{ number_format($cart->items->sum(function ($item) {return $item->price * $item->quantity;}) - 0,0,',','.') }}₫</strong>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn btn-danger btn-block mt-3">Tiến hành thanh
                            toán</a>
                    </div>
               
                @endif
            </div>
        </div>
    </div>

    <script>
        function removeItem(itemId) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                fetch(`/cart/remove/${itemId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                    })
                    .then(response => {
                        if (response.ok) {
                            location.reload();
                        } else {
                            alert('Đã có lỗi xảy ra, vui lòng thử lại.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
        document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('updateCartForm').submit();
        });
    </script>
@endsection
