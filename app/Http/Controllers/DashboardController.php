<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));

        // Metrics
        $newOrderCount = $this->getNewOrderCount();
        $revenueCurrentMonth = $this->getRevenueCurrentMonth();
        $percentageMonth = $this->gatPercentageMonth();
        $revenueCurrentYear = $this->getRevenueCurrentYear();
        $percentageYear = $this->gatPercentageYear();
        $totalCustomers = $this->getTotalCustomers();

        // Latest Order
        $orders = $this->getRecentOrders();
        // Customer Pie
        $customerPercentage = $this->calculateCustomerPercentages();

        // Revenue Chart
        $monthlyRevenue = $this->getMonthlyRevenue($year);
        // Revenue Chart Currency
        $monthlyRevenueCurrency = $this->getMonthlyRevenueCurrency($year);

        // Order Count and Revenue
        $orderCountRevenue = $this->getOrderCountRevenue($year);
        // Sales Share
        $salesShare = $this->getSalesShare($year);

        // Top Customers by Revenue
        $topCustomersOrder = $this->getTopCustomersOrder();
        $topCustomersRevenue = $this->getTopCustomersRevenue();
        // dd($topCustomersRevenue);
        $title = 'Home Page';

        return view('index', compact(
            'title',
            'totalCustomers',
            'revenueCurrentMonth',
            'newOrderCount',
            'revenueCurrentYear',
            'percentageYear',
            'percentageMonth',
            'year',
            'orders',
            'customerPercentage',

            'monthlyRevenue',
            'monthlyRevenueCurrency',

            'orderCountRevenue',
            'salesShare',

            'topCustomersOrder',
            'topCustomersRevenue'
        ));
    }


    private function getNewOrderCount()
    {
        return Order::where('status', 'new')->count();
    }

    private function calculateCustomerPercentages()
    {
        $totalCustomers = Customer::count();
        $memberCount = Customer::where('status', 'Member')->count();
        $commonCount = Customer::where('status', 'Common')->count();

        $memberPercentage = $totalCustomers > 0 ? ($memberCount / $totalCustomers) * 100 : 0;
        $commonPercentage = $totalCustomers > 0 ? ($commonCount / $totalCustomers) * 100 : 0;

        return [
            'member' => number_format($memberPercentage, 2),
            'common' => number_format($commonPercentage, 2)
        ];
    }

    private function getRevenueCurrentMonth()
    {
        $revenue = Order::whereMonth('order_date', date('n'))
            ->whereYear('order_date', date('Y'))
            ->sum(DB::raw('grand_total * exchange_rate'));

        return $revenue;
    }
    private function getRevenueLastMonth()
    {

        $revenue = Order::whereMonth('order_date', date('n') - 1)
            ->whereYear('order_date', date('Y'))
            ->sum(DB::raw('grand_total * exchange_rate'));

        return $revenue;
    }

    private function gatPercentageMonth()
    {
        $revenueCurrentMonth = $this->getRevenueCurrentMonth();
        $revenueLastMonth = $this->getRevenueLastMonth();

        if ($revenueLastMonth == 0) {
            return [
                "percentage" => 0,
                "status" => "flat"
            ];
        }

        $percentage = intval((($revenueCurrentMonth - $revenueLastMonth) / $revenueLastMonth) * 100);
        $status = $percentage > 0 ? "up" : ($percentage < 0 ? "down" : "flat");
        $percentage = abs($percentage);

        return [
            "percentage" => $percentage,
            "status" => $status
        ];
    }

    private function getRevenueCurrentYear()
    {
        $revenue = Order::whereYear('order_date', date('Y'))
            ->sum(DB::raw('grand_total * exchange_rate'));

        return $revenue;
    }
    private function getRevenueLastYear()
    {
        $revenue = Order::whereYear('order_date', date('Y') - 1)
            ->sum(DB::raw('grand_total * exchange_rate'));

        return $revenue;
    }

    private function gatPercentageYear()
    {
        $revenueCurrentYear = $this->getRevenueCurrentYear() ?? 1;
        $revenueLastYear = $this->getRevenueLastYear();

        if ($revenueLastYear == 0) {
            return [
                "percentage" => 0,
                "status" => "flat"
            ];
        }

        $percentage = intval((($revenueCurrentYear - $revenueLastYear) / $revenueLastYear) * 100);
        $status = $percentage > 0 ? "up" : ($percentage < 0 ? "down" : "flat");
        $percentage = abs($percentage);

        return [
            "percentage" => $percentage,
            "status" => $status
        ];
    }


    private function getTotalCustomers()
    {
        return Customer::count();
    }

    private function getRecentOrders()
    {
        return Order::with('customer')->orderByDesc('order_date')->where('status', '=', 'new')->take(5)->get();
    }

    private function getMonthlyRevenue($year)
    {
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenue = Order::whereMonth('order_date', $i)
                ->whereYear('order_date', $year)
                ->sum(DB::raw('grand_total * exchange_rate'));

            $monthlyRevenue[] = [
                'x' => Carbon::create($year, $i)->format('M'),
                'y' => $revenue,
            ];
        }
        return $monthlyRevenue;
    }

    private function getMonthlyRevenueCurrency($year)
    {

        $monthlyRevenueCurrency = [];

        // FOR CURRENCIES
        $currencies = ['idr', 'usd', 'eur'];
        foreach ($currencies as $currency) {
            $data = [];

            for ($i = 1; $i <= 12; $i++) {
                $revenue = Order::whereMonth('order_date', $i)
                    ->whereYear('order_date', $year)
                    ->where('currency', $currency)
                    ->sum(DB::raw('grand_total'));

                $data[] = [
                    'x' => Carbon::create($year, $i)->format('M'),
                    'y' => $revenue,
                ];
            }

            $monthlyRevenueCurrency[$currency] = $data;
        }

        // FOR AVERAGE
        $avgGrowth = [];
        for ($i = 0; $i < 12; $i++) {
            $idr = $monthlyRevenueCurrency['idr'][$i]['y'];
            $usd = $monthlyRevenueCurrency['usd'][$i]['y'];
            $eur = $monthlyRevenueCurrency['eur'][$i]['y'];

            $avg = ($idr + $usd + $eur) / 3;

            $avgGrowth[] = [
                'x' => $monthlyRevenueCurrency['idr'][$i]['x'], // for month select one,
                'y' => round($avg)
            ];
        }

        $monthlyRevenueCurrency['avg_growth'] = $avgGrowth;

        return $monthlyRevenueCurrency;
    }

    private function getOrderCountRevenue($year)
    {
        $orderCountRevenue = [
            'revenue' => [],
            'order_count' => [],
            'currency' => []
        ];

        $currencies = ['idr', 'usd', 'eur'];
        foreach ($currencies as $currency) {
            $orders = Order::whereYear('order_date', $year)
                ->where('currency', $currency)
                ->selectRaw('SUM(grand_total) as revenue, COUNT(*) as order_count')
                ->first();

            $orderCountRevenue['revenue'][] = (float) ($orders->revenue ?? 0);
            $orderCountRevenue['order_count'][] = (int) ($orders->order_count ?? 0);
            $orderCountRevenue['currency'][] = strtoupper($currency);
        }

        return $orderCountRevenue;
    }

    private function getSalesShare($year)
    {
        $currencies = ['idr', 'usd', 'eur'];
        $series = array_fill_keys($currencies, 0);

        $result = Order::whereYear('order_date', $year)
            ->selectRaw('currency, count(orders.id) as total_orders')
            ->groupBy('currency')
            ->get();

        foreach ($result as $row) {
            if (in_array($row->currency, $currencies)) {
                $series[$row->currency] = (float) $row->total_orders;
            }
        }

        $total = array_sum($series);

        $series = $total > 0 ? array_map(fn($value) => round(($value / $total) * 100, 2), $series)  : array_fill(0, 3, 0);

        return [
            'series' => array_values($series),
            'labels' => array_map('strtoupper', $currencies)
        ];
    }

    private function getTopCustomersOrder()
    {
        $topCustomers = Customer::select('customers.name')
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->take(10)
            ->get();

        return $data = [
            "data" => $topCustomers->pluck('orders_count')->toArray(),
            "categories" => $topCustomers->pluck('name')->toArray()
        ];
    }

    private function getTopCustomersRevenue()
    {
        $topCustomers = Customer::select('customers.name')
            ->leftJoin('orders', 'orders.customer_id', '=', 'customers.id')
            ->selectRaw('COALESCE(SUM(orders.grand_total * orders.exchange_rate), 0) AS total_orders')
            ->groupBy('customers.id', 'customers.name')
            ->orderByDesc('total_orders')
            ->take(10)
            ->get();

        return $data = [
            "data" => $topCustomers->pluck('total_orders')->toArray(),
            "categories" => $topCustomers->pluck('name')->toArray()
        ];
    }
}
