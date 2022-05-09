<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Trademark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function show(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->first();
        $childrens = Category::where('parent_id', $category->id)->get();
        if (count($childrens) < 1){
            $products = Product::where([['category_id', $category->id], ['status', Product::STATUS_BUY]]);
        } else {
            $arr[] = $category->id;
            foreach ($childrens as $children){
                $arr[] = $children->id;
            }

            $products = Product::whereIn('category_id', $arr)->where('status', Product::STATUS_BUY);
        }


        if ($request->has('price')) {
            $price = $request->get('price');
            switch ($price) {
                case '5':
                    $products = $products->where('sale_price', '<', 5000000);
                    break;
                case '5-10':
                    $products = $products->whereBetween('sale_price', [5000000, 10000000]);
                    break;
                case '10-15':
                    $products = $products->whereBetween('sale_price', [10000000, 15000000]);
                    break;
                case '15-20':
                    $products = $products->whereBetween('sale_price', [15000000, 20000000]);
                    break;
                case '20-25':
                    $products = $products->whereBetween('sale_price', [20000000, 25000000]);
                    break;
                case '25':
                    $products = $products->where('sale_price', '>', 25000000);
                    break;
                default:

            }
        }

        if ($request->has('trademark')) {
            $slugTrade  = $request->get('trademark');
            $trademark  = Trademark::where('slug', $slugTrade)->first();
            $products   = $products->where('trademark_id', $trademark->id);
        }

        if ($request->has('sort')) {
            $sort = $request->get('sort');
            $products = $products->orderBy('sale_price', '' . $sort . '');
        } else {
            $products = $products->orderBy('created_at', 'DESC');
        }

        $products = $products->paginate(16);

        return view('frontend.pages.category')->with([
            'products' => $products,
            'category' => $category
        ]);
    }

}
