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
        $monthlyRevenue = $this->getMonthlyRevenue($year);
        $newOrderCount = $this->getNewOrderCount();
        $customerPercentage = $this->calculateCustomerPercentages();

        $revenueCurrentMonth = $this->getRevenueCurrentMonth();
        $revenueLastMonth = $this->getRevenueLastMonth();
        $percentageMonth = $this->gatPercentageMonth();

        $revenueCurrentYear = $this->getRevenueCurrentYear();
        $revenueLastYear = $this->getRevenueLastYear();
        $percentageYear = $this->gatPercentageYear();

        $totalCustomers = $this->getTotalCustomers();
        $orders = $this->getRecentOrders();

        // dd($percentageYear);
        $title = 'Home Page';

        return view('index', compact(
            'title',
            'totalCustomers',
            'revenueCurrentMonth',
            'newOrderCount',
            'revenueCurrentYear',
            'percentageYear',
            'percentageMonth',
            'monthlyRevenue',
            'year',
            'orders',
            'customerPercentage'
        ));
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

    private function gatPercentageMonth(){
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
        $revenue = Order::whereYear('order_date', date('Y') -1 )
            ->sum(DB::raw('grand_total * exchange_rate'));

        return $revenue;
    }

    private function gatPercentageYear(){
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
        return Order::with('customer')->orderByDesc('order_date')->take(5)->get();
    }
}
