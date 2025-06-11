<div class="dropdown">
    <a href="#" class="text-decoration-none text-light" id="favoriteDropdown" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        <i class="far fa-heart"></i>
        <span class="qty bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
            style="width: 20px; height: 20px;">{{ \App\Models\Favorite::where('user_id', auth()->id())->count() }}</span>
        <span>Yêu thích</span>
    </a>
    <ul class="dropdown-menu menu-cart dropdown-menu-end" aria-labelledby="favoriteDropdown" style="max-height: 300px; overflow-y: auto;">
        <!-- Danh sách sản phẩm yêu thích -->
        @foreach (\App\Models\Favorite::where('user_id', auth()->id())->with('product.variants')->get() as $favorite)
            <li class="mb-3">
                <a class="" href="#">
                    <div class="row d-flex">
                        <div class="col-4 col-md-3">
                            <a href="{{ route('productsClient.show', $favorite->product->id) }}">
                                <div class="">
                                    <img src="{{ asset('images/' . $favorite->product->image_url) }}" class="img-fluid"
                                        alt="{{ $favorite->product->name }}">
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-7">
                            <a href="{{ route('productsClient.show', $favorite->product->id) }}"
                                class="text-decoration-none text-dark-custom product-widget-name">{{ $favorite->product->name }}</a>
                        </div>
                        <div class="col-2 d-flex align-items-center">
                            <button type="button" class="btn btn-outline-danger btn-sm rounded-circle" onclick="removeFavorite({{ $favorite->product_id }})">&times;</button>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
        <!-- Kết thúc danh sách sản phẩm -->

        <!-- Phân cách hoặc các phần khác trong dropdown -->
        <div class="btn-group w-100">
            <a class="btn bg-primary-custom btn-sm" href="{{ route('favorites.index') }}">Xem danh sách yêu thích</a>
        </div>

        <!-- Kết thúc phần khác trong dropdown -->
    </ul>
</div>

<script>
    function removeFavorite(productId) {
        fetch(`/favorites/${productId}`, {
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
