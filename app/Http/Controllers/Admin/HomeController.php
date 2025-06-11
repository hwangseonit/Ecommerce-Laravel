<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        $totalUsers = User::count();
        $title = "Báo cáo Doanh Thu";
        $filterBy = $request->query('filter_by', 'day');
        $startDate = $request->query('start_date', Carbon::now()->startOfDay()->toDateString());
        $endDate = $request->query('end_date', Carbon::now()->endOfDay()->toDateString());

        $currentDate = Carbon::now();
        $previousPeriodStartDate = null;
        $previousPeriodEndDate = null;
        $periodLabel = 'hôm qua';
        $revenue_type = 'Theo Ngày';

        if ($filterBy == 'month') {
            $selectedMonth = $request->query('month', $currentDate->format('Y-m'));
            if (Carbon::parse($selectedMonth)->greaterThan($currentDate)) {
                return redirect()->back()->with('error', 'Tháng được chọn không thể lớn hơn tháng hiện tại.');
            }
            $startDate = Carbon::parse($selectedMonth)->startOfMonth()->toDateString();
            $endDate = Carbon::parse($selectedMonth)->endOfMonth()->toDateString();
            $previousPeriodStartDate = Carbon::parse($selectedMonth)->subMonth()->startOfMonth()->toDateString();
            $previousPeriodEndDate = Carbon::parse($selectedMonth)->subMonth()->endOfMonth()->toDateString();
            $periodLabel = 'tháng trước';
            $revenue_type = 'Theo Tháng';
        } elseif ($filterBy == 'quarter') {
            $selectedQuarter = $request->query('quarter');
            $selectedYear = $request->query('year', $currentDate->year);

            if ($selectedQuarter == 1) {
                $startDate = Carbon::parse("$selectedYear-01-01")->toDateString();
                $endDate = Carbon::parse("$selectedYear-03-31")->toDateString();
                $previousPeriodStartDate = Carbon::parse("$selectedYear-01-01")->subMonths(3)->toDateString();
                $previousPeriodEndDate = Carbon::parse("$selectedYear-03-31")->subMonths(3)->toDateString();
            } elseif ($selectedQuarter == 2) {
                $startDate = Carbon::parse("$selectedYear-04-01")->toDateString();
                $endDate = Carbon::parse("$selectedYear-06-30")->toDateString();
                $previousPeriodStartDate = Carbon::parse("$selectedYear-04-01")->subMonths(3)->toDateString();
                $previousPeriodEndDate = Carbon::parse("$selectedYear-06-30")->subMonths(3)->toDateString();
            } elseif ($selectedQuarter == 3) {
                $startDate = Carbon::parse("$selectedYear-07-01")->toDateString();
                $endDate = Carbon::parse("$selectedYear-09-30")->toDateString();
                $previousPeriodStartDate = Carbon::parse("$selectedYear-07-01")->subMonths(3)->toDateString();
                $previousPeriodEndDate = Carbon::parse("$selectedYear-09-30")->subMonths(3)->toDateString();
            } elseif ($selectedQuarter == 4) {
                $startDate = Carbon::parse("$selectedYear-10-01")->toDateString();
                $endDate = Carbon::parse("$selectedYear-12-31")->toDateString();
                $previousPeriodStartDate = Carbon::parse("$selectedYear-10-01")->subMonths(3)->toDateString();
                $previousPeriodEndDate = Carbon::parse("$selectedYear-12-31")->subMonths(3)->toDateString();
            }
            $periodLabel = 'quý trước';
            $revenue_type = 'Theo Quý';
        } elseif ($filterBy == 'year') {
            $selectedYear = $request->query('year');
            if ($selectedYear === 'other') {
                $selectedYear = $request->query('custom_year');
            }
            $startDate = Carbon::parse("$selectedYear-01-01")->startOfYear()->toDateString();
            $endDate = Carbon::parse("$selectedYear-12-31")->endOfYear()->toDateString();
            $previousPeriodStartDate = Carbon::parse("$selectedYear-01-01")->subYear()->toDateString();
            $previousPeriodEndDate = Carbon::parse("$selectedYear-12-31")->subYear()->toDateString();
            $periodLabel = 'năm trước';
            $revenue_type = 'Theo Năm';
        } else {
            // Mặc định là lọc theo ngày
            $startDate = $request->query('start_date', Carbon::now()->startOfDay()->toDateString());
            $endDate = $request->query('end_date', Carbon::now()->endOfDay()->toDateString());
            $previousPeriodStartDate = Carbon::now()->subDay()->startOfDay()->toDateString();
            $previousPeriodEndDate = Carbon::now()->subDay()->endOfDay()->toDateString();
        }

        // Chuyển đổi ngày kết thúc thành cuối ngày
        $endDate = Carbon::parse($endDate)->endOfDay()->toDateTimeString();
        $previousPeriodEndDate = Carbon::parse($previousPeriodEndDate)->endOfDay()->toDateTimeString();

        // Revenue data
        $revenueByDay = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, SUM(final_amount) as total')
            ->groupBy('date')
            ->get();
        // Tổng số khách chưa mua hàng
        $customersWithoutOrdersInPeriod = User::whereDoesntHave('orders')->count();

        // Tổng số khách hàng quay lại
        $returningCustomersInPeriod = User::whereIn('id', function ($query) {
            $query->select('user_id')
                ->from('orders')
                ->groupBy('user_id')
                ->havingRaw('COUNT(*) > 1');
        })->count();

        // Dữ liệu doanh thu kỳ trước
        $previousRevenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [$previousPeriodStartDate, $previousPeriodEndDate])
            ->sum('final_amount');

        // Tính phần trăm thay đổi
        $currentRevenue = $revenueByDay->sum('total');
        $percentageChange = $previousRevenue > 0 ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : null;

        // Doanh thu theo danh mục sản phẩm
        $revenueByCategory = OrderItem::selectRaw('products.category_id, product_categories.category_name, SUM(order_items.total_price) as total')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->groupBy('products.category_id', 'product_categories.category_name')
            ->get();

        // Top 10 sản phẩm bán chạy trong khoảng thời gian
        // $topSellingProducts = OrderItem::selectRaw('products.id, products.name,  products.image_url, SUM(order_items.quantity) as total_quantity')
        //     ->join('products', 'order_items.product_id', '=', 'products.id')
        //     ->join('orders', 'order_items.order_id', '=', 'orders.id')
        //     ->where('orders.status', 'completed')
        //     ->whereBetween('orders.created_at', [$startDate, $endDate])
        //     ->groupBy('products.id', 'products.name',) // Thêm cột products.name vào GROUP BY
        //     ->orderBy('total_quantity', 'desc')
        //     ->take(10)
        //     ->get();
        $topSellingProducts = OrderItem::selectRaw('products.id, products.name, products.image_url, SUM(order_items.quantity) as total_quantity')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.status', 'completed')
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->groupBy('products.id', 'products.name', 'products.image_url') // Add products.image_url to GROUP BY
                ->orderBy('total_quantity', 'desc')
                ->take(10)
                ->get();



        // Top 10 sản phẩm chưa được mua trong khoảng thời gian
        $unsoldProducts = Product::select('products.*')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', function ($join) use ($startDate, $endDate) {
                $join->on('order_items.order_id', '=', 'orders.id')
                    ->where('orders.status', 'completed')
                    ->whereBetween('orders.created_at', [$startDate, $endDate]);
            })
            ->whereNull('order_items.id')
            ->orderBy('products.created_at', 'asc')
            ->take(10)
            ->get();

        //  biểu đồ 
        $selectedYear = $request->query('year', Carbon::now()->year);
        // Lấy dữ liệu doanh thu hàng tháng trong năm được chọn
        $revenueByMonth = Order::where('status', 'completed')
            ->whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, SUM(final_amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Khởi tạo mảng doanh thu với giá trị mặc định là 0 cho 12 tháng
        $revenue = array_fill(1, 12, 0);
        foreach ($revenueByMonth as $month => $total) {
            $revenue[$month] = $total;
        }

        // Lấy dữ liệu khách hàng mới hàng tháng
        $newCustomersByMonth = User::whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $newCustomers = array_fill(1, 12, 0);
        foreach ($newCustomersByMonth as $month => $total) {
            $newCustomers[$month] = $total;
        }

        // Lấy dữ liệu khách hàng quay lại hàng tháng
        $returningCustomersByMonth = Order::where('status', 'completed')
            ->whereYear('created_at', $selectedYear)
            ->selectRaw('MONTH(created_at) as month, COUNT(DISTINCT user_id) as total')
            ->whereIn('user_id', function ($query) {
                $query->select('user_id')
                    ->from('orders')
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(*) > 1');
            })
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $returningCustomers = array_fill(1, 12, 0);
        foreach ($returningCustomersByMonth as $month => $total) {
            $returningCustomers[$month] = $total;
        }



        if ($request->ajax()) {
            return view('pages.admin.home.revenue_data', compact(
                'revenueByDay',
                'percentageChange',
                'periodLabel',
                'revenue_type',
                'revenueByCategory',
                'totalUsers',
                'customersWithoutOrdersInPeriod',
                'returningCustomersInPeriod',
                'topSellingProducts',
                'unsoldProducts',
                'revenue',
                'newCustomers',
                'returningCustomers'
            ))->render();
        }

        return view('pages.admin.home.home', compact(
            'revenueByDay',
            'startDate',
            'endDate',
            'filterBy',
            'title',
            'percentageChange',
            'periodLabel',
            'revenue_type',
            'revenueByCategory',
            'totalUsers',
            'customersWithoutOrdersInPeriod',
            'returningCustomersInPeriod',
            'topSellingProducts',
            'unsoldProducts',
            'revenue',
            'newCustomers',
            'returningCustomers'
        ));
    }
}
