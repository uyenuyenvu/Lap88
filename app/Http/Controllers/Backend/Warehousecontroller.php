<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Warehousecontroller extends Controller
{
    public function index(Request $request){
        $keyW = '';
        $warehouses = Warehouse::distinct()->selectRaw('product_id, sum(sold) as sold, sum(entered) as entered');
        if ($request->has('q')) {
            $keyW = $request->get('q');
            $products = Product::where('name', 'LIKE', '%'.$keyW.'%')->get();
            foreach ($products as $product){
                $arrId[] = $product->id;
            }
            $warehouses = $warehouses->whereIn('product_id', $arrId);
        }

        if ($request->has('status')) {
            $arrId=[];
            $status = $request->get('status');
            $products = Product::where('status',(int)$status)->get();
            foreach ($products as $product){
                $arrId[] = $product->id;
            }
            $warehouses = $warehouses->whereIn('product_id', $arrId);
        }

        $warehouses = $warehouses->groupBy('product_id')
            ->orderBy('created_at', 'DESC')
            ->paginate(20, ['product_id']);

        return view('backend.warehouses.index')->with([
            'warehouses'    => $warehouses,
            'keyW'          => $keyW
        ]);
    }
}
