@extends ('admin.layout.main')

@section('content')
@include('admin.layout.alert')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 ">
                    <div class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between">
                        <h5 class="text-white text-capitalize ps-3">Chi tiết sản phẩm</h5>
                    </div>
                </div>
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="../assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                Richard Davis
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                CEO / Co-Founder
                            </p>
                        </div>
                    </div>

                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên biến thể</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Màu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dung Dượng</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày thêm</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ asset('assets/assets/img/team-2.jpg')}} " class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Iphone 15</h6>
                                                <p class="text-xs text-secondary mb-0">10.000.000 vnđ</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Iphone 12</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">10</p>

                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-success">Hiển thị</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">23/04/18</span>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-primary text-capitalize text-xs mb-0" data-bs-toggle="modal" data-bs-target="#editModal1">
                                            Edit
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade modal-lg" id="editModal1" tabindex="-1" aria-labelledby="editModalLabel1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel1">Sửa sản phẩm</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="">
                                                            <div class="row">
                                                                <div class="mb-3 col-6">
                                                                    <label for="category_id" class="form-label">Loại sản phẩm</label>
                                                                    <input type="text" class="form-control" id="category_id" name="category_id">
                                                                </div>
                                                                <div class="mb-3 col-6">
                                                                    <label for="name" class="form-label">Tên sản phẩm</label>
                                                                    <input type="text" class="form-control" id="name" name="name">
                                                                </div>

                                                                <div class="mb-3 col-6">
                                                                    <label for="price" class="form-label">Giá</label>
                                                                    <input type="number" class="form-control" id="price" name="price">
                                                                </div>
                                                                <div class="mb-3 col-6">
                                                                    <label for="discounted_price" class="form-label">Giá giảm</label>
                                                                    <input type="number" class="form-control" id="discounted_price" name="discounted_price">
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
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ asset('assets/assets/img/team-2.jpg')}} " class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Iphone 15</h6>
                                                <p class="text-xs text-secondary mb-0">10.000.000 vnđ</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Iphone 13</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">10</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-danger">Ẩn</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">23/04/18</span>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-primary text-capitalize text-xs mb-0" data-bs-toggle="modal" data-bs-target="#editModal1">
                                            Edit
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade modal-lg" id="editModal1" tabindex="-1" aria-labelledby="editModalLabel1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel1">Sửa sản phẩm</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="">
                                                            <div class="row">
                                                                <div class="mb-3 col-6">
                                                                    <label for="category_id" class="form-label">Loại sản phẩm</label>
                                                                    <input type="text" class="form-control" id="category_id" name="category_id">
                                                                </div>
                                                                <div class="mb-3 col-6">
                                                                    <label for="name" class="form-label">Tên sản phẩm</label>
                                                                    <input type="text" class="form-control" id="name" name="name">
                                                                </div>

                                                                <div class="mb-3 col-6">
                                                                    <label for="price" class="form-label">Giá</label>
                                                                    <input type="number" class="form-control" id="price" name="price">
                                                                </div>
                                                                <div class="mb-3 col-6">
                                                                    <label for="discounted_price" class="form-label">Giá giảm</label>
                                                                    <input type="number" class="form-control" id="discounted_price" name="discounted_price">
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
      
                </div>
            </div>
        </div>
    </div>


</div>
@endsection