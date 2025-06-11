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
                            <a href="{{ route('menu.create') }}"><button type="button"
                                    class="btn btn-primary text-capitalize me-4">
                                    Thêm mới
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">

                                <tbody>
                                    @if ($menus->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">Chưa có menu</td>
                                        </tr>
                                    @else
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Tên
                                                </th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Danh mục cha</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Slug</th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">
                                                    Trạng thái</th>
                                                <th class="text-secondary opacity-7"></th>
                                            </tr>
                                        </thead>
                                        @foreach ($menus as $menu)
                                            <tr>
                                                <td>
                                                    <h6 class=" px-3 mb-0 text-sm">{{ $menu->name }}</h6>
                                                </td>
                                                <td>
                                                    @if ($menu->parent)
                                                        <p class="text-xs font-weight-bold mb-0">{{ $menu->parent->name }}
                                                        </p>
                                                    @else
                                                        <p class="text-xs font-weight-bold mb-0">Không có</p>
                                                    @endif
                                                </td>

                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $menu->slug }} </p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span
                                                        class="badge badge-sm {{ $menu->status == 1 ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                        {{ $menu->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                                                    </span>
                                                </td>

                                                <td class="align-middle text-center d-flex justify-content-center">
                                                    <a href="{{ route('menu.edit', $menu->id) }}">
                                                        <button type="button"
                                                            class="btn btn-warning text-capitalize text-xs mb-0 me-2">
                                                            Sửa
                                                        </button>
                                                    </a>
                                                    <form id="delete-form-{{ $menu->id }}"
                                                        action="{{ route('menu.destroy', $menu->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDelete({{ $menu->id }})"
                                                            class="btn btn-danger text-capitalize text-xs mb-0">
                                                            Xóa
                                                        </button>
                                                    </form>
                                                    <script>
                                                        function confirmDelete(id) {
                                                            if (confirm('Bạn có chắc muốn xóa?')) {
                                                                document.getElementById('delete-form-' + id).submit();
                                                            }
                                                        }
                                                    </script>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
