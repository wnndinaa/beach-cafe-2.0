<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{

public function index(Request $request)
{
    // Get the time range filter (weekly, monthly, or yearly)
    $timeRange = $request->input('time_range', 'weekly');  // Default to 'weekly'

    // Calculate time range bounds
    switch ($timeRange) {
        case 'monthly':
            $startDate = Carbon::now()->subMonth();
            break;
        case 'yearly':
            $startDate = Carbon::now()->subYear();
            break;
        case 'weekly':
        default:
            $startDate = Carbon::now()->subWeek();
            break;
    }

    // HOT SELLING: Top 3 menus with the most orders
    $hotSelling = DB::table('order_items')
        ->join('menus', 'order_items.menu_id', '=', 'menus.id')
        ->select('menus.id', 'menus.name', 'menus.image_path', 'menus.status', 'menus.price', DB::raw('SUM(order_items.order_quantity) as total_quantity'))
        ->groupBy('menus.id', 'menus.name', 'menus.image_path', 'menus.status', 'menus.price')
        ->orderByDesc('total_quantity')
        ->limit(3)
        ->get();

    // HOT ITEMS THIS WEEK: Orders made within the selected time range
    $hotThisWeek = DB::table('order_items')
        ->join('menus', 'order_items.menu_id', '=', 'menus.id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->select('menus.id', 'menus.name', 'menus.image_path', 'menus.status', 'menus.price', DB::raw('SUM(order_items.order_quantity) as total_quantity'))
        ->whereBetween('orders.order_date', [$startDate, Carbon::now()])
        ->groupBy('menus.id', 'menus.name', 'menus.image_path', 'menus.status', 'menus.price')
        ->orderByDesc('total_quantity')
        ->limit(3)
        ->get();

    // NEW MENU: Menus added in the last 2 weeks
    $newMenusLast2Weeks = DB::table('menus')
        ->where('created_at', '>=', Carbon::now()->subWeeks(2))
        ->get();

    if ($newMenusLast2Weeks->isEmpty()) {
        // If no menus were added in the last 2 weeks, get the top 3 most recent menus
        $newMenus = DB::table('menus')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();
    } else {
        // Otherwise, return the menus added in the last 2 weeks
        $newMenus = $newMenusLast2Weeks;
    }

    // Format the created_at date for each menu
    $newMenus = $newMenus->map(function ($menu) {
        $menu->created_at = Carbon::parse($menu->created_at)->format('d/m/Y');
        return $menu;
    });

    // MOST PROFIT: Top 5 menus with the highest total profit
    $mostProfit = DB::table('order_items')
        ->join('menus', 'order_items.menu_id', '=', 'menus.id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->select('menus.id', 'menus.name', 'menus.image_path', 'menus.status', 'menus.price', DB::raw('SUM(order_items.order_quantity) as total_quantity'))
        ->whereBetween('orders.order_date', [$startDate, Carbon::now()])
        ->groupBy('menus.id', 'menus.name', 'menus.image_path', 'menus.status', 'menus.price')
        ->orderByDesc(DB::raw('SUM(order_items.order_quantity) * menus.price'))  // Sort by total profit
        ->limit(5)
        ->get();

    // LEAST PROFIT: Top 3 menus with the lowest total profit
    $leastProfit = DB::table('order_items')
        ->join('menus', 'order_items.menu_id', '=', 'menus.id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->select('menus.id', 'menus.name', 'menus.image_path', 'menus.status', 'menus.price', DB::raw('SUM(order_items.order_quantity) as total_quantity'))
        ->whereBetween('orders.order_date', [$startDate, Carbon::now()])
        ->groupBy('menus.id', 'menus.name', 'menus.image_path', 'menus.status', 'menus.price')
        ->orderBy(DB::raw('SUM(order_items.order_quantity) * menus.price'))  // Sort by lowest total profit
        ->limit(3)
        ->get();

    // Return to the view with data
    return view('dashboard', [
        'hotSelling' => $hotSelling,
        'hotThisWeek' => $hotThisWeek,
        'newMenus' => $newMenus,
        'mostProfit' => $mostProfit,
        'leastProfit' => $leastProfit,
        'timeRange' => $timeRange,
    ]);
}


}