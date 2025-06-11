@extends ('layouts.admin.main')

@section('content')
    @include('components.admin.alert')
    <div class="container-fluid py-4">
        <form id="filterForm" action="{{ route('admin.home.index') }}" method="GET" class="row mb-5">
            <div class="col-md-3">
                <label for="filter_by" class="form-label">Lọc theo</label>
                <select id="filter_by" name="filter_by" class="form-select" onchange="toggleFilterFields()">
                    <option value="day" {{ request('filter_by') == 'day' ? 'selected' : '' }}>Ngày</option>
                    <option value="month" {{ request('filter_by') == 'month' ? 'selected' : '' }}>Tháng</option>
                    <option value="quarter" {{ request('filter_by') == 'quarter' ? 'selected' : '' }}>Quý</option>
                    <option value="year" {{ request('filter_by') == 'year' ? 'selected' : '' }}>Năm</option>
                </select>
            </div>
            <div class="col-md-6" id="day_filter" style="display:none;">
                <div class="row">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Ngày bắt đầu</label>
                        <input type="date" id="start_date" name="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">Ngày kết thúc</label>
                        <input type="date" id="end_date" name="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>
                </div>
                <div id="date_error" class="text-danger" style="display: none;"></div>
            </div>
            <div class="col-md-6" id="month_filter" style="display:none;">
                <div class="col-md-3">
                    <label for="month" class="form-label">Chọn tháng</label>
                    <input type="month" id="month" name="month" class="form-control"
                        max="{{ now()->format('Y-m') }}" value="{{ request('month') }}">
                </div>
            </div>
            <div class="col-md-6" id="quarter_filter" style="display:none;">
                <div class="col-md-3">
                    <label for="quarter" class="form-label">Chọn quý</label>
                    <select id="quarter" name="quarter" class="form-select">
                        <option value="1" {{ request('quarter') == '1' ? 'selected' : '' }}>Quý 1</option>
                        <option value="2" {{ request('quarter') == '2' ? 'selected' : '' }}>Quý 2</option>
                        <option value="3" {{ request('quarter') == '3' ? 'selected' : '' }}>Quý 3</option>
                        <option value="4" {{ request('quarter') == '4' ? 'selected' : '' }}>Quý 4</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6" id="year_filter" style="display:none;">
                <div class="row">
                    <div class="col-md-6">
                        <label for="year" class="form-label">Chọn năm</label>
                        <select id="year" name="year" class="form-select">
                            <!-- JavaScript will populate this -->
                        </select>
                    </div>
                    <div class="col-md-6" id="custom_year_container" style="display:none;">
                        <label for="custom_year" class="form-label">Nhập năm</label>
                        <input type="number" id="custom_year" name="custom_year" class="form-control"
                            placeholder="Nhập năm khác" oninput="validateCustomYear()">
                        <div id="year_error" class="text-danger" style="display: none;">Năm được chọn không thể lớn hơn năm
                            hiện tại</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary mb-0 mt-md-0 mt-2">Chọn</button>
            </div>
        </form>
        <div class="row ">
            <div class=" col-md-6  mb-4">
                <div class="card z-index-2 ">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                            <div class="chart">
                                biểu đồ
                                <canvas id="chart-bars" class="chart-canvas" height="212" width="428"
                                    style="display: block; box-sizing: border-box; height: 170px; width: 342.8px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0 ">Website Views</h6>
                        <p class="text-sm ">Last Campaign Performance</p>
                        <hr class="dark horizontal">
                        <div class="d-flex ">
                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                            <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-md-6  mb-4">
                <div class="card z-index-2  ">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                            <div class="chart">
                                biểu đồ
                                <canvas id="chart-line" class="chart-canvas" height="212" width="428"
                                    style="display: block; box-sizing: border-box; height: 170px; width: 342.8px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0 "> Daily Sales </h6>
                        <p class="text-sm "> (<span class="font-weight-bolder">+15%</span>) increase in today sales.
                        </p>
                        <hr class="dark horizontal">
                        <div class="d-flex ">
                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                            <p class="mb-0 text-sm"> updated 4 min ago </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="result">
            @include('pages.admin.home.revenue_data', ['revenueByDay' => $revenueByDay])
        </div>

    </div>
    <script>
        function toggleFilterFields() {
            var filterBy = document.getElementById('filter_by').value;
            document.getElementById('day_filter').style.display = filterBy === 'day' ? 'block' : 'none';
            document.getElementById('month_filter').style.display = filterBy === 'month' ? 'block' : 'none';
            document.getElementById('quarter_filter').style.display = filterBy === 'quarter' ? 'block' : 'none';
            document.getElementById('year_filter').style.display = filterBy === 'year' ? 'block' : 'none';
        }

        function populateYears() {
            var yearSelect = document.getElementById('year');
            var customYearInput = document.getElementById('custom_year');
            var currentYear = new Date().getFullYear();

            // Thêm các năm từ hiện tại trở về trước 5 năm
            for (var year = currentYear; year >= currentYear - 5; year--) {
                var option = document.createElement('option');
                option.value = year;
                option.text = year;
                yearSelect.appendChild(option);
            }

            // Thêm tùy chọn "Khác"
            var otherOption = document.createElement('option');
            otherOption.value = 'other';
            otherOption.text = 'Khác';
            yearSelect.appendChild(otherOption);

            yearSelect.addEventListener('change', function() {
                if (yearSelect.value === 'other') {
                    document.getElementById('custom_year_container').style.display = 'block';
                } else {
                    document.getElementById('custom_year_container').style.display = 'none';
                    customYearInput.value = '';
                    document.getElementById('year_error').style.display = 'none';
                }
            });

            // Đặt giá trị mặc định từ request nếu có
            yearSelect.value = "{{ request('year') }}";
            if (yearSelect.value === 'other') {
                document.getElementById('custom_year_container').style.display = 'block';
                customYearInput.value = "{{ request('custom_year') }}";
            }
        }

        function validateCustomYear() {
            var customYearInput = document.getElementById('custom_year');
            var currentYear = new Date().getFullYear();
            var yearError = document.getElementById('year_error');

            if (customYearInput.value > currentYear) {
                yearError.style.display = 'block';
            } else {
                yearError.style.display = 'none';
            }
        }

        function validateDateRange() {
            var startDateInput = document.getElementById('start_date');
            var endDateInput = document.getElementById('end_date');
            var startDate = new Date(startDateInput.value);
            var endDate = new Date(endDateInput.value);
            var currentDate = new Date();
            var dateError = document.getElementById('date_error');

            if (startDate > endDate) {
                dateError.innerText = 'Ngày kết thúc không thể nhỏ hơn ngày bắt đầu.';
                dateError.style.display = 'block';
                return false;
            } else if (startDate > currentDate || endDate > currentDate) {
                dateError.innerText = 'Ngày bắt đầu và ngày kết thúc không thể lớn hơn ngày hiện tại.';
                dateError.style.display = 'block';
                return false;
            } else {
                dateError.style.display = 'none';
                return true;
            }
        }

        function populateQuarters() {
            var quarterSelect = document.getElementById('quarter');
            var currentMonth = new Date().getMonth() + 1; // Lấy tháng hiện tại (0-11) + 1
            var currentQuarter = Math.ceil(currentMonth / 3); // Xác định quý hiện tại (1-4)

            // Ẩn các quý trong tương lai
            for (var i = currentQuarter + 1; i <= 4; i++) {
                quarterSelect.querySelector('option[value="' + i + '"]').style.display = 'none';
            }

            // Đặt giá trị mặc định từ request nếu có
            var selectedQuarter = "{{ request('quarter') }}";
            if (selectedQuarter) {
                quarterSelect.value = selectedQuarter;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleFilterFields();
            populateYears();
            populateQuarters();

            var form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                if (validateDateRange()) {
                    submitForm();
                }
            });
        });

        function submitForm() {
            var form = document.querySelector('form');
            var formData = new FormData(form);
            var xhr = new XMLHttpRequest();
            xhr.open('GET', form.action + '?' + new URLSearchParams(formData).toString(), true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.querySelector('#result').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
@endsection
