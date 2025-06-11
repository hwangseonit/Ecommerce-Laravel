@extends ('layouts.client.main')
@section('content')
    @include('components.client.alert')
    <div class="mt-5" ng-controller= "LoginController">
        <section class="login_box_area section_gap ">
            <div class="container " style=" margin-top: 20px;">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="login_box_img">
                            <img src="" alt="">
                            <div class="hover">
                                <h4 style="font-weight: 600;">Chưa có tài khoản?</h4>
                                <p>Đăng ký ngay để nhận nhiều ưu đãi bất ngờ</p>
                                <a class="btn-danger btn" href="{{route('register')}}">Đăng ký tài khoản</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="">
                            <h3 style="font-weight: 600;">Đăng nhập</h3>
                            <form action="{{route('login.store')}}" method="post">
                                {!! csrf_field() !!}
                                <div class="mb-2">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-2">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3 form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Nhớ tài khoản</label>
                                </div>
                                <div class="text-center mb-2">
                                    <button type="submit" name="submit" class="btn-danger btn ">Đăng nhập</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
