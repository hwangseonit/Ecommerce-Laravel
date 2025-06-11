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
                            <a href="{{ route('productCategories.index') }}"><button type="button"
                                    class="btn btn-primary text-capitalize me-4">
                                    Danh sách
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2 mx-3">
                        <div class="row ">
                          
                            <div class="col-6">
                                <div class="p-3">
                                    <form id="productCategoriesEditForm" action="{{ route('productCategories.update', $productCategory->id) }}" method="post" >
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="category_name" class="form-label">Tên danh mục</label>
                                            <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $productCategory->category_name }}">
                                            @error('category_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Trạng thái</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="active" name="status" value="1" {{ $productCategory->status == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="active">Hiển thị</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="inactive" name="status" value="0" {{ $productCategory->status == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inactive">Ẩn</label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('productCategories.index') }}"><button type="button" class="btn btn-secondary me-2">Đóng</button></a>
                                            <button type="submit" class="btn btn-primary">Lưu</button>
                                        </div>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>





                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
