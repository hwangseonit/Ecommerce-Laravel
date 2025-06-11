@extends ('layouts.admin.main')

@section('content')
    @include('components.admin.alert')
    <div class="container-fluid py-4">
       
    </div>
   
    <script>
        // Dữ liệu mẫu cho doanh thu hàng tháng
        const months = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];
        const revenue = [7000000, 15000000, 20000000, 18000000, 22000000, 24000000, 1000000000, 25000000, 27000000, 32000000, 34000000, 36000000];

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
                                return value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
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
                datasets: [
                    {
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
