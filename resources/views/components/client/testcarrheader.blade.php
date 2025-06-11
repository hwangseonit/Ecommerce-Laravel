<!-- resources/views/components/cart_header.blade.php -->
<div class="cart-header">
    <div class="dropdown">
        <a href="#" class="text-decoration-none text-light" id="cartDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-shopping-cart"></i>
            <span class="qty bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">{{ \App\Models\Cart::totalItems() }}</span>
            <span>Giỏ hàng</span>
        </a>
        <ul class="dropdown-menu menu-cart dropdown-menu-end" aria-labelledby="cartDropdown">
            @foreach(\App\Models\Cart::getCartItems() as $item)
                <li class="mb-3">
                    <a class="" href="#">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="#">
                                    <div class="">
                                        <img src="{{ asset('images/' . $item->product->image_url) }}" class="card-img-top" alt="{{ $item->product->name }}">
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-8">
                                <a href="#" class="text-decoration-none text-dark-custom product-widget-name">{{ $item->product->name }}</a>
                                <p style="font-size: 14px;" class="card-text m-0">{{ number_format($item->price, 0, ',', '.') }} VND</p>
                                <samp class="text-end">{{ $item->quantity }}x</samp>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
            <div class="btn-group w-100">
                <a class="btn bg-primary-custom btn-sm" href="#">Xem giỏ hàng</a>
                <a class="btn btn-danger-custom btn-sm" href="#">Thanh toán <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </ul>
    </div>
</div>
