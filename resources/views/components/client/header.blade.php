<header>
    <div id="header">
        <div class="container">
            <div class="row align-items-center">
                <!-- LOGO -->
                <div class="col-xl-3 col-lg-3 col-md-12 p-0">
                    <a href="/" class="logo text-decoration-none text-light">
                        <h3 class="ms-1 font-weight-bold text-white" class="text-white">Cellphone</span><span
                            style="color: #D10024;">S</h3>
                    </a>
                </div>
                <!-- /LOGO -->
                <!-- SEARCH BAR -->
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="header-search">
                        <form action="{{ route('productsClient.index') }}" method="GET">
                            <input class="input" name="search" style=" padding: 10px; border-radius: 50px 0 0 50px;"
                                placeholder="Nhập tìm kiếm..." name="search">
                            <button class="search-btn">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
                <!-- /SEARCH BAR -->
                <!-- Nút -->
                <div class="col-xl-3 col-lg-3 col-md-6 ">
                    <div class="header-ctn d-flex   align-items-center p-0">
                        <!-- Yêu thích -->
                        @include('components.client.favorite_header')
                        <!-- /Yêu thích -->
                        <!-- Giỏ hàng -->
                        @include('components.client.cart_header')
                        <!-- /Giỏ hàng -->
                        <!-- Dropdown user -->
                        <div class="dropdown">
                            <a href="#" class="text-decoration-none " id="dropdownUser2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                @if (Auth::check())
                                    @if (!empty(Auth::user()->image))
                                        <img src="{{ asset('images/' . Auth::user()->image) }}" alt="user-image"
                                            class="rounded-circle w-50">
                                    @else
                                        <img src="{{ asset('images/no_image.jpg') }}" alt="default-image"
                                            class="rounded-circle w-50">
                                    @endif
                                @else
                                    <img src="{{ asset('images/no_image.jpg') }}" alt="default-image"
                                        class="rounded-circle w-50">
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end text-small text-user"
                                aria-labelledby="dropdownUser2">
                                @if (Auth::check())
                                    <li><a class="dropdown-item" href="{{ route('account.index') }}">Tài khoản</a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.my') }}">Đơn hàng của tôi</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Đăng xuất</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('login') }}">Đăng nhập</a></li>
                                    <li><a class="dropdown-item" href="{{ route('register') }}">Đăng Ký</a></li>
                                @endif
                            </ul>
                        </div>
                        <!-- /Dropdown user -->
                    </div>
                </div>
                <!-- /Nút -->
            </div>
        </div>
    </div>
</header>
