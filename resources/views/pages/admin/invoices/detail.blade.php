@extends ('layouts.admin.main')

@section('content')
@include('components.admin.alert')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 ">
                    <div class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between">
                        <h5 class="text-white text-capitalize ps-3">Chi tiết hóa đơn</h5>
                    </div>
                </div>
                <div class="row m-3 border border-danger border-dashed">
                    <div class="row text-center">
                        <h5 class="text-danger text-uppercase mb-0 mt-3">Hóa đơn chi tiết</h5>
                        <span class="font-weight-bold text-uppercase">Mã hóa đơn: KH123</span>
                        <span class="font-weight-bold text-uppercase">Ngày mua hàng: 26/03/2024</span>
                    </div>
                    <div class="row mx-3 ">
                        <span><span class="font-weight-bold">Tên khách hàng:</span> Nguyễn Quốc Khanh</span>
                        <span><span class="font-weight-bold">Số điện thoại:</span> 03242585307</span>
                        <span><span class="font-weight-bold">Địa chỉ:</span> Trung hưng, cờ đỏ, cần thơ</span>
                    </div>
                    <div class="card-body px-3 ">
                        <div class="table-responsive  p-0">
                            <table class="table table-boder align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Sản phẩm</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Giá</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dung Dượng</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Số lượng</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="{{url ('admin/san-pham/chi-tiet')}}" class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="{{ asset('uploads/team-2.jpg')}} " class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">Iphone 15</h6>
                                                    <p class="text-xs text-secondary mb-0">Đen titan</p>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">15.000.000 VNĐ</p>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">258 GB</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">2</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">15.000.000 VNĐ</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="{{url ('admin/san-pham/chi-tiet')}}" class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="{{ asset('uploads/team-2.jpg')}} " class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">Iphone 15</h6>
                                                    <p class="text-xs text-secondary mb-0">Đen titan</p>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">15.000.000 VNĐ</p>
                                        </td>

                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">258 GB</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">1</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">15.000.000 VNĐ</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-end font-weight-bold">Tổng tiền:</td>
                                        <td class="font-weight-bold text-danger">30.000.000 VNĐ</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection