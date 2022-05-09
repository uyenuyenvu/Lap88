<?php

namespace App\Http\Controllers\Backend;

use App\Exports\CategoriesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Imports\CategoriesImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Trademark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'DESC')->paginate(20);
        $parents = Category::where('parent_id', 0)->get();
        return view('backend.categories.index')->with([
            'categories'    => $categories,
            'parents'       => $parents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', 0)->get();
        return view('backend.categories.create')->with([
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->except('_token');
        $data['slug'] = Str::slug($data['name']);
        $data['user_id'] = Auth::user()->id;
        $category = Category::create($data);

        if (!empty($data['trademark_id'])){
            $category->trademarks()->attach($data['trademark_id'], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        Cache::forget('menuCategories');
        Cache::forget('listCategories');

        if ($category){
            return redirect()->route('backend.category.index')->with("success",'Tạo mới thành công');
        }
        return redirect()->route('backend.category.index')->with("error",'Tạo mới thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return view('backend.categories.edit')->with([
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = Category::find($id);
        $this->authorize('update', $category);

        $data = $request->except('_token');
        $data['slug'] = Str::slug($request->get('name'));
        $data['updated_at'] = Carbon::now();

        $category->update($data);
        if (!empty($data['trademark_id'])){
            $category->trademarks()->sync($data['trademark_id'], [
                'created_at' => Carbon::now(),
            ]);
        } else{
            $category->trademarks()->detach();
        }

        Cache::forget('menuCategories');
        Cache::forget('listCategories');

        if ($category){
            return redirect()->route('backend.category.index')->with("success",'Thay đổi thành công');
        }
        return redirect()->route('backend.category.index')->with("error",'Thay đổi thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $children = Category::where('parent_id', $category->id)->get();
        $products = Product::where('category_id', $category->id)->get();
        if (count($children)>0){
            foreach ($children as $child) {
                $child->parent_id = 0;
                $child->save();
            }
        }

        if (count($products)>0){
            foreach ($products as $product) {
                $product->category_id = 0;
                $product->save();
            }
        }
        $category->trademarks()->detach();
        $category->delete();

        Cache::forget('menuCategories');
        Cache::forget('listCategories');

        if ($category){
            return redirect()->route('backend.category.index')->with("success",'Xóa thành công');
        }
        return redirect()->route('backend.category.index')->with("error",'Xóa thất bại');
    }

    public function export()
    {
        return Excel::download(new CategoriesExport(), 'categories.xlsx');
    }

    public function import(){
        Excel::import(new CategoriesImport(),request()->file('file'));

        return back();
    }
}
