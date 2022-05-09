<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all()->count();
        $products = Product::orderBy('created_at', 'DESC')->offset(0)->limit(10)->get();
        $countProducts = Product::all()->count();
        $orders = Order::all()->count();
        //Ngày đầu tiên của tháng
        $startOfMonth = Carbon::now()->startOfMonth();
        //Ngày cuối cùng của tháng
        $endOfMonth = Carbon::now()->endOfMonth();
        $gets = Statistic::whereBetween('order_date', [$startOfMonth, $endOfMonth])->orderBy('order_date', 'ASC')->get();
        $profit = 0;
        foreach ($gets as $get){
            $profit += $get->profit;
        }
        return view('backend.dashboard')->with([
            'products'      => $products,
            'countProducts' => $countProducts,
            'users'         => $users,
            'orders'        => $orders,
            'profit'        => $profit
        ]);
    }
}
