<?php

namespace App\Http\Controllers\Backend;

use App\Exports\StatisticsExport;
use App\Exports\WarehousesExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Statistic;
use App\Models\Trademark;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StatisticController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);
        $orders     = Order::all()->count();
        $products   = Product::all()->count();
        $categories = Category::all()->count();
        $trademarks = Trademark::all()->count();
        $users = User::all()->count();

        if ($request->has('from_sale_date') && $request->has('to_sale_date')){
            $fromDate = $request->get('from_sale_date');
            $toDate = $request->get('to_sale_date');
            $warehouses = Warehouse::distinct()  //truy vấn và trả các kết quả riêng
                ->selectRaw('product_id, sum(sold) as sold, sum(entered) as entered')
                ->whereBetween('sale_date', [$fromDate, $toDate])
                ->groupBy('product_id')
                ->orderBy('created_at', 'DESC')
                ->paginate(12, ['product_id']);
        } else {
            //Ngày đầu tiên của tháng
            $startOfMonth = Carbon::now()->startOfMonth();
            //Ngày cuối cùng của tháng
            $endOfMonth = Carbon::now()->endOfMonth();

            $warehouses = Warehouse::distinct()
                ->selectRaw('product_id, sum(sold) as sold, sum(entered) as entered')
                ->whereBetween('sale_date', [$startOfMonth, $endOfMonth])
                ->groupBy('product_id')
                ->orderBy('created_at', 'DESC')
                ->paginate(12, ['product_id']);
        }

        return view('backend.statistics.index')->with([
            'orders'        => $orders,
            'products'      => $products,
            'categories'    => $categories,
            'trademarks'    => $trademarks,
            'users'         => $users,
            'warehouses'    => $warehouses
        ]);
    }

    public function filterByDate(Request $request)
    {
        $data = $request->all();
        $fromDate = $data['from_date'];
        $toDate = $data['to_date'];

        $gets = Statistic::whereBetween('order_date', [$fromDate, $toDate])->orderBy('order_date', 'ASC')->get();

        foreach ($gets as $get) {
            $chartData[] = array(
                'period'    => $get->order_date,
                'order'     => $get->total_order,
                'revenue'   => $get->revenue,
                'profit'    => $get->profit,
                'quantity'  => $get->quantity
            );
        }
        echo $data = json_encode($chartData);
    }

    public function filterOption(Request $request)
    {
        //Ngày đầu tiên của tuần
        $startOfWeek = Carbon::now()->startOfWeek();
        //Ngày cuối của tuần
        $endOfWeek = Carbon::now()->endOfWeek();
        //Ngày đầu tiên của tuần trước
        $startOfLastWeek = Carbon::now()->subDays(7)->startOfWeek();
        //Ngày cuối cùng của tuần trước
        $endOfLastWeek = Carbon::now()->subDays(7)->endOfWeek();

        //Ngày đầu tiên của tháng
        $startOfMonth = Carbon::now()->startOfMonth();
        //Ngày cuối cùng của tháng
        $endOfMonth = Carbon::now()->endOfMonth();
        //Ngày đầu tiên của tháng trước
        $startOfLastMonth = Carbon::now()->subDays(31)->startOfMonth();
        //Ngày cuối cùng của tháng trước
        $endOfLastmonth = Carbon::now()->subDays(31)->endOfMonth();

        //Ngày đầu tiên của năm
        $startOfYear = Carbon::now()->startOfYear();
        //Ngày cuối cùng của năm
        $endOfYear = Carbon::now()->endOfYear();

        $data = $request->get('filter_value');
        switch ($data) {
            case 'this_week':
                $gets = Statistic::whereBetween('order_date', [$startOfWeek, $endOfWeek])->orderBy('order_date', 'ASC')->get();
                break;
            case 'last_week':
                $gets = Statistic::whereBetween('order_date', [$startOfLastWeek, $endOfLastWeek])->orderBy('order_date', 'ASC')->get();
                break;
            case 'this_month':
                $gets = Statistic::whereBetween('order_date', [$startOfMonth, $endOfMonth])->orderBy('order_date', 'ASC')->get();
                break;
            case 'last_month':
                $gets = Statistic::whereBetween('order_date', [$startOfLastMonth, $endOfLastmonth])->orderBy('order_date', 'ASC')->get();
                break;
            case 'this_year':
                $gets = Statistic::whereBetween('order_date', [$startOfYear, $endOfYear])->orderBy('order_date', 'ASC')->get();
                break;
        }
        foreach ($gets as $get) {
            $chartData[] = array(
                'period'    => $get->order_date,
                'order'     => $get->total_order,
                'revenue'   => $get->revenue,
                'profit'    => $get->profit,
                'quantity'  => $get->quantity
            );
        }

        echo $data = json_encode($chartData);
    }

    public function export(Request $request)
    {
        $fromDate = $request->get('from-date');
        $toDate = $request->get('to-date');
        return Excel::download(new StatisticsExport($fromDate, $toDate), 'statistic.xlsx');
    }

    public function exportWarehouse(Request $request)
    {
        $fromDate = $request->get('from_sale_date');
        $toDate = $request->get('to_sale_date');
        return Excel::download(new WarehousesExport($fromDate, $toDate), 'warehouse.xlsx');
    }
}
