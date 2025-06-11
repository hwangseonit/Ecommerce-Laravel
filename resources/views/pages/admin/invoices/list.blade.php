@extends ('layouts.admin.main')

@section('content')
@include('components.admin.alert')

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 ">
          <div class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex align-items-center justify-content-between">
            <h5 class="text-white text-capitalize ps-3">Danh sách hóa đơn</h5>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">STT</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Mã hóa đơn</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Khách hàng</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">địa chỉ</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày mua</th>
                  <th class="text-secondary opacity-7"></th>
                </tr>
              </thead>
              <tbody>
                <tr class="">
                  <td>
                    <p class="text-xs font-weight-bold mb-0 ps-3">1</p>
                  </td>
                  <td>
                    <a href="{{ asset('admin/hoa-don/chi-tiet')}}" class="text-xs font-weight-bold mb-0">KH123</a>
                  </td>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div>
                        <img src="{{ asset('uploads/team-2.jpg')}} " class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">Quốc Khanh</h6>
                        <p class="text-xs text-secondary mb-0">0342585307</p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0">Trung hưng, cờ đỏ, cần thơ</p>

                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="badge badge-sm bg-gradient-success">Đã thanh toán</span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">23/04/18</span>
                  </td>
                  <td class="align-middle">
                    <button type="button" class="btn btn-primary text-capitalize text-xs mb-0" data-bs-toggle="modal" data-bs-target="#editModal1">
                      Edit
                    </button>
                    <!-- Modal -->
                    <div class="modal fade " id="editModal1" tabindex="-1" aria-labelledby="editModalLabel1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel1">Sửa trạng thái</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form id="">
                              <div class="row">

                                <div class="mb-3 ">
                                  <label for="status" class="form-label">Trạng thái</label>
                                  <select class="form-select" id="status" name="status">
                                    <option value="unpaid">Chưa thanh toán</option>
                                    <option value="paid">Đã thanh toán</option>
                                    <option value="canceled">Hủy</option>
                                  </select>
                                </div>


                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-primary">Lưu</button>
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