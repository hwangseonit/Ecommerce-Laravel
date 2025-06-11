@extends('layouts.admin.main')

@section('content')
    @include('components.admin.alert')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3">
                        <div class="bg-gradient-dark shadow-danger border-radius-lg pt-4 pb-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
                            <h5 class="text-white text-capitalize ps-3 mb-0">{{ $title }}</h5>
                            <div class="d-flex flex-column flex-md-row me-3">
                                <!-- Form tìm kiếm -->
                                <form id="searchForm" action="{{ route('user.index') }}" method="GET" class="d-flex me-md-3 mb-3 mb-md-0">
                                    <div class="input-group input-group-outline">
                                        <input id="searchInput" type="text" name="search" class="form-control" placeholder="Tìm kiếm..." onfocus="focused(this)" onfocusout="defocused(this)" value="{{ request('search') }}">
                                    </div>
                                </form>
                                <!-- Form lọc loại tài khoản -->
                                <form id="usertypeForm" action="{{ route('user.index') }}" method="GET" class="d-flex me-md-3 mb-3 mb-md-0">
                                    <div class="input-group input-group-outline">
                                        <select id="usertypeFilter" name="usertype" class="form-control rounded" onchange="this.form.submit()">
                                            <option value="">Tất cả loại tài khoản</option>
                                            <option value="1" {{ request('usertype') == '1' ? 'selected' : '' }}>Quản trị</option>
                                            <option value="2" {{ request('usertype') == '2' ? 'selected' : '' }}>Khách hàng</option>
                                        </select>
                                    </div>
                                </form>
                                <script>
                                    $(document).ready(function() {
                                        let typingTimer;
                                        let doneTypingInterval = 1000;

                                        $('#searchInput').on('keyup', function() {
                                            clearTimeout(typingTimer);
                                            typingTimer = setTimeout(doneTyping, doneTypingInterval);
                                        });

                                        function doneTyping() {
                                            $('#searchForm').submit();
                                        }
                                    });
                                </script>
                                <a href="{{ route('user.create') }}">
                                    <button type="button" class="btn btn-primary text-capitalize mb-0">Thêm mới</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"><input type="checkbox" id="select-all"></th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tài khoản</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Số điện thoại</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">Chưa có tài khoản</td>
                                        </tr>
                                    @else
                                        @foreach ($users as $index => $user)
                                            <tr>
                                                <td class="text-center"><input type="checkbox" class="user-checkbox" value="{{ $user->id }}"></td>
                                                <td class="text-center">
                                                    <p class="text-xs font-weight-bold mb-0 px-3">{{ $users->firstItem() + $index }}</p>
                                                </td>
                                                <td>
                                                    <a href="{{ route('user.show', $user->id) }}" class="d-flex">
                                                        <div>
                                                            <img src="{{ $user->image ? asset('images/' . $user->image) : asset('images/no_images.jpg') }}" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $user->usertype == 1 ? 'Quản trị' : 'Khách hàng' }}</p>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $user->phone }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $user->email }}</p>
                                                </td>
                                                <td class="text-center text-sm">
                                                    <button class="btn btn-sm toggle-status-user mb-0 {{ $user->status == 1 ? 'btn-success' : 'btn-danger' }}" data-id="{{ $user->id }}" data-status="{{ $user->status }}">
                                                        {{ $user->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                    </button>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('user.edit', $user->id) }}">
                                                            <button type="button" class="btn btn-warning text-capitalize text-xs mb-0 me-2">Sửa</button>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <div class="ms-3 mt-3">
                                <button id="select-all-btn" class="btn btn-primary p-2 me-3">Chọn tất cả</button>
                                <button id="delete-selected" class="btn btn-primary p-2">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ $users->links() }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Chọn tất cả checkbox khi bấm vào nút "Chọn tất cả"
            document.getElementById('select-all-btn').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.user-checkbox');
                const selectAll = document.getElementById('select-all');
                const isChecked = !selectAll.checked;

                checkboxes.forEach((checkbox) => {
                    checkbox.checked = isChecked;
                });

                selectAll.checked = isChecked;
            });

            // Chọn tất cả checkbox
            document.getElementById('select-all').addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.user-checkbox');
                checkboxes.forEach((checkbox) => {
                    checkbox.checked = this.checked;
                });
            });

            // Xóa các tài khoản đã chọn
            document.getElementById('delete-selected').addEventListener('click', function() {
                const selectedUsers = [];
                document.querySelectorAll('.user-checkbox:checked').forEach((checkbox) => {
                    selectedUsers.push(checkbox.value);
                });

                if (selectedUsers.length > 0) {
                    if (confirm('Bạn có chắc chắn muốn xóa các tài khoản đã chọn?')) {
                        fetch('{{ route('user.bulkDelete') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    ids: selectedUsers
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    location.reload();
                                } else {
                                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                                }
                            })
                            .catch((error) => {
                                console.error('Error:', error);
                            });
                    }
                } else {
                    alert('Vui lòng chọn ít nhất một tài khoản để xóa.');
                }
            });
        });
    </script>
@endsection
