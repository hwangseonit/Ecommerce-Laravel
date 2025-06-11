@extends('layouts.admin.main')
@section('content')
    @include('components.admin.alert')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3">
                        <div class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between">
                            <h5 class="text-white text-capitalize ps-3">{{ $title }}</h5>
                            <a href="{{ route('user.index') }}" class="btn btn-primary text-capitalize me-4">Danh sách người dùng</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 mx-3">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <img id="previewImage" class="w-100" src="{{ $user->image ? asset('images/' . $user->image) : asset('images/no_images.jpg') }}" alt="Preview">
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="p-3">
                                    <form id="userEditForm" action="{{ route('user.update', $user->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image" class="form-label">Ảnh</label>
                                            <input type="file" class="form-control" id="image" name="image" onchange="previewImage(event)">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="usertype" class="form-label">Loại tài khoản</label>
                                            <select class="form-select" id="usertype" name="usertype">
                                                <option value="1" {{ $user->usertype == 2 ? 'selected' : '' }}>Khách hàng</option>
                                                <option value="2" {{ $user->usertype == 1 ? 'selected' : '' }}>Quản trị</option>
                                            </select>
                                            @error('usertype')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Trạng thái</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="active" name="status" value="1" {{ $user->status == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="active">Hiển thị</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inactive" name="status" value="0" {{ $user->status == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inactive">Ẩn</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('user.index') }}" class="btn btn-secondary me-2">Hủy</a>
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                    </form>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
