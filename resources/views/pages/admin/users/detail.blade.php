@extends ('layouts.admin.main')

@section('content')
    @include('components.admin.alert')

    <div class="container ">
        <div class="row">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1920&amp;q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class=" d-flex justify-content-between">
                    <div class="row gx-4 mb-2">
                        <div class="col-auto">
                            <div class="avatar avatar-xl position-relative">
                                <img src="{{ $user->image ? asset('images/' . $user->image) : asset('images/no_images.jpg') }}"
                                    class="w-100 border-radius-lg shadow-sm">
                            </div>
                        </div>
                        <div class="col-auto my-auto">
                            <div class="h-100">
                                <h5 class="mb-1">
                                    {{ $user->name }}
                                </h5>
                                <p class="mb-0 font-weight-normal text-sm">
                                    @if ($user->usertype == 1)
                                        Khách hàng
                                    @elseif($user->usertype == 2)
                                        Quản trị
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="me-3">
                        <a href="{{ route('user.index') }}"><button type="button"
                                class="btn btn-primary text-capitalize ">
                                Danh sách 
                            </button>
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-xl-4">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                                <div class="row">
                                    <div class="col-md-7 d-flex align-items-center">
                                        <h6 class="mb-0">Thông tin cá nhân</h6>
                                    </div>

                                </div>
                            </div>
                            <div class="card-body p-3">
                                <p class="text-sm">
                                    Xin chào, tôi là Khanh, Quyết định: Nếu bạn không thể quyết định thì câu trả lời là
                                    không.
                                    Nếu hai con đường khó khăn như nhau,
                                    hãy chọn con đường đau đớn hơn trong thời gian ngắn (né tránh nỗi đau là tạo ra ảo tưởng
                                    về sự bình đẳng).
                                    Chưa mở rộng
                                </p>
                                <hr class="horizontal gray-light my-4">
                                <ul class="list-group">
                                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Họ và
                                            tên:</strong> &nbsp;Chưa mở rộng</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Số điện
                                            thoại:</strong> &nbsp; Chưa mở rộng</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong
                                            class="text-dark">Email:</strong> &nbsp; Khanh@gmail.com</li>
                                    <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Địa
                                            chỉ:</strong> &nbsp; Chưa mở rộng </li>
                                    <li class="list-group-item border-0 ps-0 pb-0">
                                        <strong class="text-dark text-sm">Mạng xã hội:</strong> &nbsp;
                                        <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                            <i class="fab fa-facebook fa-lg" aria-hidden="true">Chưa mở rộng</i>
                                        </a>
                                        <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                            <i class="fab fa-twitter fa-lg" aria-hidden="true">Chưa mở rộng</i>
                                        </a>
                                        <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                            <i class="fab fa-instagram fa-lg" aria-hidden="true">Chưa mở rộng</i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-8 ">
                        <div class="p-3">
                            <h6 class="mb-1">Dự án (Chưa mở rộng)</h6>
                            <p class="text-sm">Kiến trúc sư thiết kế nhà ở</p>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
                                <div class="card card-blog card-plain">
                                    <div class="card-header p-0 mt-n4 mx-3">
                                        <a class="d-block shadow-xl border-radius-xl">
                                            <img src="{{ asset('images/home-decor-1.jpg') }}" alt="Ảnh mờ bóng"
                                                class="img-fluid shadow border-radius-xl">
                                        </a>
                                    </div>
                                    <div class="card-body p-3">
                                        <p class="mb-0 text-sm">Dự án #2</p>
                                        <a href="javascript:;">
                                            <h5>
                                                Hiện đại
                                            </h5>
                                        </a>
                                        <p class="mb-4 text-sm">
                                            Khi Uber đang giải quyết một lượng lớn sự rối loạn trong quản lý nội bộ.
                                        </p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xem dự
                                                án</button>
                                            <div class="avatar-group mt-2">
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Elena Morison" data-bs-original-title="Elena Morison">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-1.jpg') }}">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Ryan Milly" data-bs-original-title="Ryan Milly">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-2.jpg') }}">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Nick Daniel" data-bs-original-title="Nick Daniel">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-3.jpg') }}">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Peterson" data-bs-original-title="Peterson">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-4.jpg') }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
                                <div class="card card-blog card-plain">
                                    <div class="card-header p-0 mt-n4 mx-3">
                                        <a class="d-block shadow-xl border-radius-xl">
                                            <img src="{{ asset('images/home-decor-2.jpg') }}" alt="Ảnh mờ bóng"
                                                class="img-fluid shadow border-radius-lg">
                                        </a>
                                    </div>
                                    <div class="card-body p-3">
                                        <p class="mb-0 text-sm">Dự án #1</p>
                                        <a href="javascript:;">
                                            <h5>
                                                Bắc Âu
                                            </h5>
                                        </a>
                                        <p class="mb-4 text-sm">
                                            Âm nhạc là điều mà mỗi người có ý kiến cụ thể của riêng mình.
                                        </p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xem dự
                                                án</button>
                                            <div class="avatar-group mt-2">
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Nick Daniel" data-bs-original-title="Nick Daniel">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-3.jpg') }}">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Peterson" data-bs-original-title="Peterson">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-4.jpg') }}">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Elena Morison" data-bs-original-title="Elena Morison">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-1.jpg') }}">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Ryan Milly" data-bs-original-title="Ryan Milly">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-2.jpg') }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-xl-0 mb-4">
                                <div class="card card-blog card-plain">
                                    <div class="card-header p-0 mt-n4 mx-3">
                                        <a class="d-block shadow-xl border-radius-xl">
                                            <img src="{{ asset('images/home-decor-3.jpg') }}" alt="Ảnh mờ bóng"
                                                class="img-fluid shadow border-radius-xl">
                                        </a>
                                    </div>
                                    <div class="card-body p-3">
                                        <p class="mb-0 text-sm">Dự án #3</p>
                                        <a href="javascript:;">
                                            <h5>
                                                Tối giản
                                            </h5>
                                        </a>
                                        <p class="mb-4 text-sm">
                                            Mỗi người có khẩu vị khác nhau, và nhiều loại âm nhạc khác nhau.
                                        </p>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <button type="button" class="btn btn-outline-primary btn-sm mb-0">Xem dự
                                                án</button>
                                            <div class="avatar-group mt-2">
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Peterson" data-bs-original-title="Peterson">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-4.jpg') }}">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Nick Daniel" data-bs-original-title="Nick Daniel">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-3.jpg') }}">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Ryan Milly" data-bs-original-title="Ryan Milly">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-2.jpg') }}">
                                                </a>
                                                <a href="javascript:;" class="avatar avatar-xs rounded-circle"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    aria-label="Elena Morison" data-bs-original-title="Elena Morison">
                                                    <img alt="Hình ảnh" src="{{ asset('images/team-1.jpg') }}">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endsection
