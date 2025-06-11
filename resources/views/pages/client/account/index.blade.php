@extends('layouts.client.main')

@section('content')
    <div class="container mt-4">
        <h3 class="text-center mb-3">TÀI KHOẢN CỦA TÔI</h3>
        @include('components.client.alert')
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3 ">
                    <img id="previewImage" class=" w-100"
                        src="{{ $user->image ? asset('images/' . $user->image) : asset('images/no_images.jpg') }}"
                        alt="Preview">
                </div>
                <ul class="list-group">
                    <li class="list-group-item "><a class="nav-link" href="{{ route('orders.my') }}">Lịch sử đơn hàng</a>
                    </li>
                    <li class="list-group-item "><a class="nav-link" href="{{ route('account.change_password') }}">Đổi mật
                            khẩu</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        Thông tin cá nhân
                    </div>
                    <div class="card-body">
                        <form method="POST"  action="{{ route('account.update', $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" disabled
                                    value="{{ $user->email }} ">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ $user->phone }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Ảnh</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    onchange="previewImage(event)">
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger">Lưu thay đổi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('previewImage');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
