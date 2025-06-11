@extends ('layouts.admin.main')
@section('content')
    @include('components.admin.alert')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 ">
                        <div
                            class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between">
                            <h5 class="text-white text-capitalize ps-3">{{ $title }}</h5>
                            <a href="{{ route('banner.index') }}"><button type="button"
                                    class="btn btn-primary text-capitalize me-4">
                                    Danh sách
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 mx-3">
                        <div class="row ">
                            <div class="col-6">
                                <img id="previewImage" class="w-100" src="{{ asset('images/no_images.jpg') }}"
                                    alt="Preview">
                            </div>
                            <div class="col-6">
                                <div class="p-3">
                                    <form id="bannerAddForm" action="{{ route('banner.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Tiêu đề</label>
                                            <input type="text" class="form-control" id="title" name="title">
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Mô tả</label>
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                            @error('description')
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

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Trạng thái</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="active" name="status"
                                                    value="1" checked>
                                                <label class="form-check-label" for="active">Hiển thị</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inactive" name="status"
                                                    value="0">
                                                <label class="form-check-label" for="inactive">Ẩn</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('banner.index') }}"><button type="button"
                                                    class="btn btn-secondary me-2">Đóng</button></a>
                                            <button type="submit" class="btn btn-primary">Thêm</button>
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
