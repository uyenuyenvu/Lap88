<?php

namespace App\Http\Controllers\Backend;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Trademark;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyW = '';
        $products = Product::where('quantity', '>=', -100);
        if ($request->has('q')) {
            $keyW = $request->get('q');
            $products->where('name', 'LIKE', '%'.$keyW.'%');
        }

        if ($request->has('trademark')) {
            $products->where('trademark_id', $request->get('trademark'));
        }

        if ($request->has('category')) {
            $products->where('category_id', $request->get('category'));
        }

        if ($request->has('status')) {
            $products->where('status', $request->get('status'));
        }

        $products = $products->orderBy('created_at', 'DESC')->paginate(20);
        return view('backend.products.index')->with([
            'products' => $products,
            'keyW' => $keyW
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->except('_token');

        if ($request->has('key') || $request->has('val')) {
            $key = $request->get('key');
            $val = $request->get('val');
            $list = [];
            $merge = [];
            for ($i = 0; $i < count($key); $i++) {
                $list = [$key[$i] => $val[$i]];
                $merge = array_merge($merge, $list);
            }
            $data['content_more'] = json_encode($merge, JSON_UNESCAPED_UNICODE);
        }

        $data['slug'] = Str::slug($request->get('name'));
        $data['quantity'] = $request->get('quantity');
        $data['user_id'] = Auth::user()->id;
        $data['created_at'] = Carbon::now();

        $product = Product::create($data);

        if ($request->hasFile('image')) {
            $files = $request->file('image');

            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $disk = 'public';
                $path = Storage::disk($disk)->putFileAs('images', $file, $name);

                $image = new Image();
                $image->name = $name;
                $image->disk = $disk;
                $image->path = $path;
                $image->product_id = $product->id;
                $image->save();
            }
        }

        $ware['product_id'] = $product->id;
        $ware['entered']    = 0;
        $ware['sold']       = 0;
        $ware['sale_date']  = Carbon::now();
        $warehouse = Warehouse::create($ware);

        if ($product && $image && $warehouse) {
            return redirect()->route('backend.product.index')->with("success", 'Tạo mới thành công');
        }
        return redirect()->route('backend.product.index')->with("error", 'Tạo mới thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('backend.products.show')->with([
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('backend.products.edit')->with([
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);
        $this->authorize('update', $product);

        $data = $request->except('_token');

        if ($request->has('key')) {
            $key = $request->get('key');
            $val = $request->get('val');
            $list = [];
            $merge = [];
            for ($i = 0; $i < count($key); $i++) {
                $list = [$key[$i] => $val[$i]];
                $merge = array_merge($merge, $list);
            }
            $data['content_more'] = json_encode($merge, JSON_UNESCAPED_UNICODE);
        } else {
            $data['content_more'] = null;
        }

        $data['slug'] = Str::slug($request->get('name'));
        $data['updated_at'] = Carbon::now();

        $product->update($data);

        if ($request->hasFile('image')) {
            $files = $request->file('image');

            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $disk = 'public';
                $path = Storage::disk($disk)->putFileAs('images', $file, $name);

                $image = new Image();
                $image->name = $name;
                $image->disk = $disk;
                $image->path = $path;
                $image->product_id = $product->id;
                $image->save();
            }
        }
        $deleteImg = $request->delete_img;
        if (!empty($deleteImg)) {
            foreach ($deleteImg as $dete) {
                $imgDelete = Image::find($dete);
                Storage::disk('public')->delete($imgDelete->path);
                $imgDelete->delete();
            }
        }

        if ($product) {
            return redirect()->route('backend.product.index')->with("success", 'Thay đổi thành công');
        }
        return redirect()->route('backend.product.index')->with("error", 'Thay đổi thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $deleteImg = Image::where('product_id', $product->id)->get();
        if (!empty($deleteImg)) {
            foreach ($deleteImg as $dete) {
                Storage::disk('public')->delete($dete->path);
                $dete->delete();
            }
        }
        $warehouse = Warehouse::where('product_id', $product->id)->first();
        $warehouse->delete();
        $product->delete();

        if ($product && $warehouse) {
            return redirect()->route('backend.product.index')->with("success", 'Xóa thành công');
        }
        return redirect()->route('backend.product.index')->with("error", 'Xóa thất bại');
    }

    public function getTrademark(Request $request){
        $id = $request->get('id');
        if ($id == 0){
            $trademark = Trademark::all();
            echo $data = json_encode($trademark);
        } else {
            $category   = Category::where('id', $id)->first();
            echo $data  = json_encode($category->trademarks);
        }
    }

    public function export()
    {
        return Excel::download(new ProductsExport(), 'products.xlsx');
    }

    public function import(){
        Excel::import(new ProductsImport(),request()->file('file'));

        return back();
    }
}
