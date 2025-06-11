@extends ('layouts.admin.main')

@section('content')
@include('components.admin.alert')

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 ">
                    <div class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between">
                        <h5 class="text-white text-capitalize ps-3">Chi tiết sản phẩm</h5>
                        <button type="button" class="btn btn-primary text-capitalize me-4" data-bs-toggle="modal" data-bs-target="#addProductVariationModal">
                            Thêm mới biến thể
                        </button>
                    </div>
                </div>
                <div class="row gx-4 mt-2 m-0 ">

                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ asset('uploads/team-2.jpg')}}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                Iphone 15
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                1000 VND
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ảnh chi tiết</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Dung Dượng</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Số lượng</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div>
                                                <img src="{{ asset('uploads/team-2.jpg')}} " class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Iphone 15</h6>
                                                <p class="text-xs text-secondary mb-0">10.000.000 vnđ</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">titan</p>
                                    </td>
                                    <td>
                                        <div data-bs-toggle="modal" data-bs-target="#imageBannerThumbModal">
                                            <img src="{{ asset('uploads/team-2.jpg') }}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">258</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">10</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <span class="badge badge-sm bg-gradient-danger">Ẩn</span>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-primary text-capitalize text-xs mb-0" data-bs-toggle="modal" data-bs-target="#editProductVariationModal">
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
    <div class="row container">
        <div>
            <div class="row mb-3">

                <div class="col-md-6 col-sm-9">
                    <div class="row">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('uploads/team-1.jpg') }}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('uploads/team-2.jpg') }}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('uploads/team-3.jpg') }}" class="d-block w-100" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <p>Mô tả chi tiết</p>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="product-details">
                        <h2 class="text-uppercase product-details-name">
                            Iphone 15
                        </h2>
                        <div>
                            <!-- Display the selected variant price -->
                            <h3 class="product-details-price">1500000 VND</h3>
                            <!-- Add logic to display old price if needed -->
                        </div>
                        <p>
                            <a class="category-detail text-decoration-none text-hover " href="">Danh mục:
                                Iphone 15</a>
                        </p>
                        <div class="row">
                            <div class="col-md-3 btn btn-primary mb-3">
                                <div class="text-dark-custom ">
                                    <input type="radio" name="gp" value="">
                                    <span class="small"> 128</span>
                                    <p class="small mb-0">1345000 VND</p>
                                </div>
                            </div>
                            <div class="col-md-3 btn btn-primary mb-3">
                                <div class="text-dark-custom">
                                    <input type="radio" name="gp" value="">
                                    <span class="small"> 128</span>
                                    <p class="small mb-0">1345000 VND</p>
                                </div>
                            </div>
                            <div class="col-md-3 btn btn-primary mb-3">
                                <div class="text-dark-custom">
                                    <input type="radio" name="gp" value="">
                                    <span class="small"> 128</span>
                                    <p class="small mb-0">1345000 VND</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 mb-3">
                                <div class="text-dark-custom">
                                    <div class="img">
                                        <img src="{{ asset('uploads/team-1.jpg') }}" class="w-100" alt="...">
                                    </div>
                                    <p class="small m-0" title="">Hồng</p>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="text-dark-custom">
                                    <div class="img">
                                        <img src="{{ asset('uploads/team-2.jpg') }}" class="w-100" alt="...">
                                    </div>
                                    <p class="small m-0" title="">Hồng</p>
                                </div>
                            </div>
                            <div class="col-md-2 mb-3">
                                <div class="text-dark-custom">
                                    <div class="img">
                                        <img src="{{ asset('uploads/team-3.jpg') }}" class="w-100" alt="...">
                                    </div>
                                    <p class="small m-0" title="">Hồng</p>
                                </div>
                            </div>
                        </div>

                        <p>Mô tả ngắn</p>
                        <p class="mb-1">Kho: 10</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal image_thumbs -->
    <div class="modal fade modal-lg" id="imageBannerThumbModal" tabindex="-1" aria-labelledby="carouselThumbIndicators" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="carouselThumbIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('uploads/team-1.jpg') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('uploads/team-2.jpg') }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('uploads/team-3.jpg') }}" class="d-block w-100" alt="...">
                            </div>
                            <!-- Add more carousel items as needed -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselThumbIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselThumbIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal image_thumbs -->
    <!-- Thêm Product Variation Modal -->
    <div class="modal fade" id="addProductVariationModal" tabindex="-1" aria-labelledby="addProductVariationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductVariationModalLabel">Thêm Biến thể Sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productVariationAddForm">
                        <input type="hidden" id="variationId" name="variationId">
                        <div class="mb-3">
                            <label for="productId" class="form-label">ID Sản phẩm</label>
                            <input type="hidden" class="form-control" id="productId" name="productId">
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="color" class="form-label">Màu sắc</label>
                                <input type="text" class="form-control" id="color" name="color">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="capacity" class="form-label">Dung lượng</label>
                                <input type="number" class="form-control" id="capacity" name="capacity">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="quantity" class="form-label">Số lượng</label>
                                <input type="number" class="form-control" id="quantity" name="quantity">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="price" class="form-label">Giá</label>
                                <input type="text" class="form-control" id="price" name="price">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="imageThumbs" class="form-label">Hình chi tiết</label>
                            <input type="file" class="form-control" id="imageThumbs" name="imageThumbs" multiple>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Thêm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <!-- Sửa Product Variation Modal -->
    <div class="modal fade" id="editProductVariationModal" tabindex="-1" aria-labelledby="editProductVariationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductVariationModalLabel">Thêm Biến thể Sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="productVariationEditForm">
                        <input type="hidden" id="variationId" name="variationId">
                        <div class="mb-3">
                            <label for="productId" class="form-label">ID Sản phẩm</label>
                            <input type="hidden" class="form-control" value="" id="productId" name="productId">
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="color" class="form-label">Màu sắc</label>
                                <input type="text" class="form-control" id="color" name="color">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="capacity" class="form-label">Dung lượng</label>
                                <input type="number" class="form-control" id="capacity" name="capacity">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="quantity" class="form-label">Số lượng</label>
                                <input type="number" class="form-control" id="quantity" name="quantity">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="price" class="form-label">Giá</label>
                                <input type="text" class="form-control" id="price" name="price">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="active" name="status" value="1" checked>
                                <label class="form-check-label" for="active">Hiển thị</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="inactive" name="status" value="0">
                                <label class="form-check-label" for="inactive">Ẩn</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <div class="mb-3">
                            <label for="imageThumbs" class="form-label">Hình chi tiết</label>
                            <input type="file" class="form-control" id="imageThumbs" name="imageThumbs" multiple>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->


</div>
@endsection