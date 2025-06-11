<div class="dropdown">
    <a href="#" class="text-decoration-none text-light" id="cartDropdown" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="fas fa-shopping-cart"></i>
        <span class="qty bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
            style="width: 20px; height: 20px;">{{ \App\Models\Cart::totalItems() }}</span>
        <span>Giỏ hàng</span>
    </a>
    <ul class="dropdown-menu menu-cart dropdown-menu-end" aria-labelledby="cartDropdown" style="max-height: 300px; overflow-y: auto;">
        <!-- Danh sách sản phẩm trong giỏ hàng -->
        @foreach (\App\Models\Cart::getCartItems() as $item)
            <li class="mb-3">
                <a class="" href="#">
                    <div class="row d-flex align-items-center">
                        <div class="col-4 col-md-3">
                            <a href="{{ route('productsClient.show', $item->product->id) }}">
                                <div class="">
                                    <img src="{{ asset('images/' . $item->product->image_url) }}" class="img-fluid"
                                        alt="{{ $item->product->name }}">
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-7">
                            <a href="{{ route('productsClient.show', $item->product->id) }}"
                                class="text-decoration-none text-dark-custom product-widget-name">{{ $item->product->name }}</a>
                            <p style="font-size: 14px;" class="card-text m-0">
                                {{ number_format($item->price, 0, ',', '.') }} ₫
                            </p>
                            <span class="text-end">{{ $item->quantity }}x</span>
                        </div>
                        <div class="col-2 d-flex align-items-center">
                            <button type="button" class="btn btn-outline-danger btn-sm rounded-circle" onclick="removeItem({{ $item->id }})">&times;</button>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
        <!-- Kết thúc danh sách sản phẩm -->

        <!-- Phân cách hoặc các phần khác trong dropdown -->
        <div class="btn-group w-100">
            <a class="btn bg-primary-custom btn-sm" href="{{ route('cart.index') }}">Xem giỏ hàng</a>
            <a class="btn btn-danger-custom btn-sm" href="{{ route('checkout.index') }}">Thanh toán <i
                    class="fa fa-arrow-circle-right"></i></a>
        </div>

        <!-- Kết thúc phần khác trong dropdown -->
    </ul>
</div>

<script>
    function removeItem(itemId) {
        fetch(`/cart/${itemId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                location.reload(); // Reload the page to update the dropdown
            } else {
                alert(data.error);
            }
        });
    }
</script>
