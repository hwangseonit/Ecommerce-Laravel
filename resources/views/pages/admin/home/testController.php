public function test(Request $request)
    {
        $title = "Báo cáo Doanh Thu | Admin KhanhUD Mobile";
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
            $startDate = Carbon::now()->startOfDay()->toDateString();
            $endDate = Carbon::now()->endOfDay()->toDateString();
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

        // Previous period revenue data
        $previousRevenue = Order::where('status', 'completed')
            ->whereBetween('created_at', [$previousPeriodStartDate, $previousPeriodEndDate])
            ->sum('final_amount');

        // Calculate percentage change
        $currentRevenue = $revenueByDay->sum('total');
        $percentageChange = $previousRevenue > 0 ? (($currentRevenue - $previousRevenue) / $previousRevenue) * 100 : null;

        // Revenue by product category
        $revenueByCategory = OrderItem::selectRaw('products.category_id, product_categories.category_name, SUM(order_items.total_price) as total')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->where('status', 'completed')
                    ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->groupBy('products.category_id', 'product_categories.category_name')
            ->get();

        if ($request->ajax()) {
            return view('pages.admin.home.revenue_data', compact('revenueByDay', 'percentageChange', 'periodLabel', 'revenue_type', 'revenueByCategory'))->render();
        }

        return view('pages.admin.home.test', compact(
            'revenueByDay',
            'startDate',
            'endDate',
            'filterBy',
            'title',
            'percentageChange',
            'periodLabel',
            'revenue_type',
            'revenueByCategory'
        ));
    }