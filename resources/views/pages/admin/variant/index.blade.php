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
                            <h5 class="text-white text-capitalize ps-3">Danh sách biến thể</h5>
                            <a href="{{ route('attributes.create') }}"><button type="button"
                                    class="btn btn-primary text-capitalize me-4">
                                    Thêm mới
                                </button>
                            </a>

                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stt
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tên biến thể</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Trạng thái</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class=" px-3">
                                                <p class="text-xs font-weight-bold mb-0">1</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">Màu</p>
                                        </td>
                                        <td class="align-middle  text-sm">
                                            <span class="badge badge-sm bg-gradient-success">Hiển thị</span>
                                        </td>
                                        <td class="align-middle">
                                            <button type="button" class="btn btn-primary text-capitalize text-xs mb-0"
                                                data-bs-toggle="modal" data-bs-target="#editModal1">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal add -->
        <div class="modal fade modal-lg" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm mới biến thể</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="category_id" class="form-label">Loại biến thể</label>
                                    <input type="text" class="form-control" id="category_id" name="category_id">
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="name" class="form-label">Tên biến thể</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="number" class="form-control" id="price" name="price">
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="discounted_price" class="form-label">Giá giảm</label>
                                    <input type="number" class="form-control" id="discounted_price"
                                        name="discounted_price">
                                </div>
                                <div class="mb-3">
                                    <label for="image_url" class="form-label">Ảnh</label>
                                    <input type="file" class="form-control" id="image_url" name="image_url">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô Tả</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" onclick="saveProduct()">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <!-- Modal edit -->
        <div class="modal fade modal-lg" id="editModal1" tabindex="-1" aria-labelledby="editModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel1">Sửa biến thể</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label for="category_id" class="form-label">Loại biến thể</label>
                                    <input type="text" class="form-control" id="category_id" name="category_id">
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="name" class="form-label">Tên biến thể</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>

                                <div class="mb-3 col-6">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="number" class="form-control" id="price" name="price">
                                </div>
                                <div class="mb-3 col-6">
                                    <label for="discounted_price" class="form-label">Giá giảm</label>
                                    <input type="number" class="form-control" id="discounted_price"
                                        name="discounted_price">
                                </div>
                                <div class="mb-3">
                                    <label for="image_url" class="form-label">Ảnh</label>
                                    <input type="file" class="form-control" id="image_url" name="image_url">
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô Tả</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" onclick="saveProduct()">Thêm</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->

    </div>
@endsection
