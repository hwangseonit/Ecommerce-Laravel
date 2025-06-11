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
        <div class="row">
            <div class="col-md-6 col-lg-6 col-xl-6 mb-6">
                <div class="card z-index-10">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-10 bg-transparent">
                        <div class="shadow-card  bg-light  border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="chart-bars" class="chart-canvas" height="212" width="428"
                                    style="display: block; box-sizing: border-box; height: 170px; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Doanh thu hàng tháng</h6>
                        <p class="text-sm">Sự phát triển doanh thu qua từng tháng trong năm:</p>
                        <hr class="dark horizontal">
                        <div class="d-flex">
                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                            <p class="mb-0 text-sm">Cập nhật hôm nay</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 mb-6">
                <div class="card z-index-10">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-10 bg-transparent">
                        <div class="shadow-card  bg-light border-radius-lg py-3 pe-1">
                            <div class="chart">
                                <canvas id="chart-line" class="chart-canvas" height="212" width="428"
                                    style="display: block; box-sizing: border-box; height: 170px; width: 100%;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6 class="mb-0">Khách hàng hàng tháng</h6>
                        <p class="text-sm">Khách hàng mới và quay lại qua từng tháng trong năm:</p>
                        <hr class="dark horizontal">
                        <div class="d-flex">
                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                            <p class="mb-0 text-sm">Cập nhật hôm nay</p>
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
    <script>
        // Dữ liệu mẫu cho doanh thu hàng tháng
        const months = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9',
            'Tháng 10', 'Tháng 11', 'Tháng 12'
        ];
        const revenue = [7000000, 15000000, 20000000, 18000000, 22000000, 24000000, 1000000000, 25000000, 27000000,
            32000000, 34000000, 36000000
        ];

        // Dữ liệu mẫu cho khách hàng hàng tháng
        const newCustomers = [50, 60, 80, 70, 90, 100, 120, 110, 130, 140, 150, 160];
        const returningCustomers = [30, 40, 50, 45, 60, 55, 70, 65, 80, 75, 90, 85];

        // Vẽ biểu đồ doanh thu
        const ctxBars = document.getElementById('chart-bars').getContext('2d');
        new Chart(ctxBars, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: revenue,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                // Định dạng giá trị trục y thành VND
                                return value.toLocaleString('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                });
                            }
                        }
                    }
                }
            }
        });

        // Vẽ biểu đồ khách hàng
        const ctxLine = document.getElementById('chart-line').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                        label: 'Khách hàng mới',
                        data: newCustomers,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true
                    },
                    {
                        label: 'Khách hàng quay lại',
                        data: returningCustomers,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        fill: true
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
