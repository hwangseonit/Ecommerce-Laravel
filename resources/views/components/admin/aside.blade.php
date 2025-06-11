<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">

    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 px-3" href="{{ url('/admin') }} " >
            <h3 class="ms-1 font-weight-bold text-white" class="text-white">Hwang</span><span
                    style="color: #D10024;">Seon</h3>
        </a>
    </div>


    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/admin') }}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>

                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('admin.orders.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">Hóa Đơn
                    </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/admin/danh-muc/danh-sach') }}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Danh Mục</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/admin/san-pham') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Sản Phẩm</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('vouchers.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Voucher</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/admin/thuoc-tinh/danh-sach') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Thuộc Tính</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/admin/loai-bai-viet/danh-sach') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">Loại Bài Viết
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/admin/bai-viet/danh-sach') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">Bài Viết
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/admin/banners/danh-sach') }}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>

                    <span class="nav-link-text ms-1">Banner</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/admin/menu/danh-sach') }}">

                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">view_in_ar</i>
                    </div>

                    <span class="nav-link-text ms-1">Menu</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/admin/tai-khoan/danh-sach') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1">Tài Khoản
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ url('/') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                    </div>
                    <span class="nav-link-text ms-1"> Trang Chủ Website
                    </span>
                </a>
            </li>
        </ul>
    </div>
</aside>
