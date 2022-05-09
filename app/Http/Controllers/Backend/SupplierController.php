<?php

namespace App\Http\Controllers\Backend;

use App\Exports\SuppliersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Imports\SuppliersImport;
use App\Models\Product;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyS = '';
        if ($request->has('q')) {
            $keyS = $request->get('q');
            $suppliers = Supplier::search($request)->paginate(20);
        } else {
            $suppliers = Supplier::orderBy('created_at', 'DESC')->paginate(20);
        }

        return view('backend.suppliers.index')->with([
            'suppliers' => $suppliers,
            'keyS'      => $keyS
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('category_id', 'ASC')->get();
        return view('backend.suppliers.create')->with([
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
        $data = $request->except('_token');
        $data['user_id'] = Auth::user()->id;
        $supplier = Supplier::create($data);

        if (!empty($data['product_id'])){
            $supplier->products()->attach($data['product_id'], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        if ($supplier) {
            return redirect()->route('backend.supplier.index')->with("success", 'Tạo mới thành công');
        }
        return redirect()->route('backend.supplier.index')->with("error", 'Tạo mới thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        return view('backend.suppliers.show')->with([
            'supplier' => $supplier
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $products = Product::orderBy('category_id', 'ASC')->get();
        return view('backend.suppliers.edit')->with([
            'supplier' => $supplier,
            'products' => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, $id)
    {
        $supplier = Supplier::find($id);

        $data = $request->except('_token');
        $data['updated_at'] = Carbon::now();

        $supplier->update($data);
        if (!empty($data['product_id'])){
            $supplier->products()->sync($data['product_id'], [
                'created_at' => Carbon::now(),
            ]);
        } else{
            $supplier->products()->detach();
        }

        if ($supplier){
            return redirect()->route('backend.supplier.index')->with("success",'Thay đổi thành công');
        }
        return redirect()->route('backend.supplier.index')->with("error",'Thay đổi thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->products()->detach();
        $supplier->delete();

        if ($supplier){
            return redirect()->route('backend.supplier.index')->with("success",'Xóa thành công');
        }
        return redirect()->route('backend.supplier.index')->with("error",'Xóa thất bại');
    }

    public function export()
    {
        return Excel::download(new SuppliersExport(), 'suppliers.xlsx');
    }

    public function import(){
        Excel::import(new SuppliersImport(),request()->file('file'));

        return back();
    }
}
