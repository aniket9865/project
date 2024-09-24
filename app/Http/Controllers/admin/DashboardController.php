<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
//    public function index() {
//        // Get total orders where status is not 'cancelled'
//        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
//
//        // Get total products
//        $totalProducts = Product::count();
//
//        // Get total customers with role 1
//        $totalCustomers = User::where('role', 1)->count();
//
//        // Get total revenue where status is not 'cancelled'
//        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('grand_total');
//
//        // Get this month's revenue
//        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
//        $currentDate = Carbon::now()->format('Y-m-d');
//
//        // Revenue This Month
//        $revenueThisMonth = Order::where('status', '!=', 'cancelled')
//            ->whereDate('created_at', '>=', $startOfMonth)
//            ->whereDate('created_at', '<=', $currentDate)
//            ->sum('grand_total');
//
//        // Last month revenue
//        $lastMonthStartDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d');
//        $lastMonthEndDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d');
//        $lastMonthName = Carbon::now()->subMonth()->startOfMonth()->format('M');
//
//        $revenueLastMonth = Order::where('status', '!=', 'cancelled')
//            ->whereDate('created_at', '>=', $lastMonthStartDate)
//            ->whereDate('created_at', '<=', $lastMonthEndDate)
//            ->sum('grand_total');
//
//
//        // Last 30 days sales
//        $lastThirtyDayStartDate = Carbon::now()->subDays(30)->format('Y-m-d');
//        $revenueLastThirtyDays = Order::where('status', '!=', 'cancelled')
//            ->whereDate('created_at', '>=', $lastThirtyDayStartDate)
//            ->whereDate('created_at', '<=', $currentDate)
//            ->sum('grand_total');
//
//        return view('admin.dashboard', [
//            'totalOrders' => $totalOrders,
//            'totalProducts' => $totalProducts,
//            'totalCustomers' => $totalCustomers,
//            'totalRevenue' => $totalRevenue,
//            'revenueThisMonth' => $revenueThisMonth,
//            'revenueLastMonth' => $revenueLastMonth,
//            'revenueLastThirtyDays' => $revenueLastThirtyDays,
//            'lastMonthName' => $lastMonthName,
//        ]);
//
//    }

    private function calculateRevenue($startDate, $endDate = null) {
        $endDate = $endDate ?? Carbon::now();
        return Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('grand_total');
    }

    public function index() {
        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 1)->count();

        // Calculate total revenue from all orders (no need for a minValue)
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('grand_total');

        // Calculate revenue this month
        $revenueThisMonth = $this->calculateRevenue(Carbon::now()->startOfMonth());

        // Calculate revenue last month
        $revenueLastMonth = $this->calculateRevenue(
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        );

        // Calculate revenue for the last 30 days
        $revenueLastThirtyDays = $this->calculateRevenue(Carbon::now()->subDays(30));

        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'totalProducts' => $totalProducts,
            'totalCustomers' => $totalCustomers,
            'totalRevenue' => $totalRevenue,
            'revenueThisMonth' => $revenueThisMonth,
            'revenueLastMonth' => $revenueLastMonth,
            'revenueLastThirtyDays' => $revenueLastThirtyDays,
            'lastMonthName' => Carbon::now()->subMonth()->format('M'),
        ]);
    }


}
