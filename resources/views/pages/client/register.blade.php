@extends ('layouts.client.main')
@section('content')
    @include('components.client.alert')
    <div class="mt-5" ng-controller = "RegisterController">
        <section class="login_box_area section_gap ">
            <div class="container " style=" margin-top: 20px;">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login_box_img">
                            <img src="" alt="">
                            <div class="hover">
                                <h4 style="font-weight: 600;">Đã có tài khoản</h4>
                                <p>Đăng nhập ngay</p>
                                <a class="btn-danger btn" href="{{route('login')}}">Đăng nhập</a>
                            </div>
                        </div>
                    </div>
                    <!-- Đăng ký -->
                    <div class="col-lg-6">
                        <div class="login_form_inner">
                            <h3 style="font-weight: 600;">Đăng ký </h3>
                            <form action="{{route('register.store')}}" method="post">
                                {!! csrf_field() !!}
                                <div class="mb-2">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Tên">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Số điện tho">
                                    @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-2">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu">
                                    @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class=" mb-2">
                                    <button type="submit" name="submit" class="btn-danger btn ">Đăng ký</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
@endsection
