<?php

namespace App\Http\Controllers\Backend;

use App\Exports\TrademarksExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTrademarkRequest;
use App\Http\Requests\UpdateTrademarkRequest;
use App\Imports\TrademarksImport;
use App\Models\Product;
use App\Models\Trademark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class TrademarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trademarks = Trademark::orderBy('created_at', 'DESC')->paginate(20);
        return view('backend.trademarks.index')->with([
            'trademarks' => $trademarks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.trademarks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrademarkRequest $request)
    {
        $data = $request->except('_token');
        $data['slug'] = Str::slug($request->get('name'));
        $data['user_id'] = Auth::user()->id;

        $trademark = Trademark::create($data);

        Cache::forget('listTrademarks');

        if ($trademark) {
            return redirect()->route('backend.trademark.index')->with("success", 'Tạo mới thành công');
        }
        return redirect()->route('backend.trademark.index')->with("error", 'Tạo mới thất bại');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Trademark $trademark)
    {
        $this->authorize('update', $trademark);
        return view('backend.trademarks.edit')->with([
            'trademark' => $trademark
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrademarkRequest $request, $id)
    {
        $trademark = Trademark::find($id);
        $this->authorize('update', $trademark);

        $data = $request->except('_token');
        $data['slug'] = Str::slug($request->get('name'));
        $data['updated_at'] = Carbon::now();
        $trademark->update($data);

        Cache::forget('listTrademarks');

        if ($trademark) {
            return redirect()->route('backend.trademark.index')->with("success", 'Thay đổi thành công');
        }
        return redirect()->route('backend.trademark.index')->with("error", 'Thay đổi thất bại');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trademark $trademark)
    {
        $this->authorize('delete', $trademark);
        $products = Product::where('trademark_id', $trademark->id)->get();
        if (count($products) > 0) {
            foreach ($products as $product) {
                $product->trademark_id = 0;
                $product->save();
            }
        }
        $trademark->delete();
        $trademark->categories()->detach();

        Cache::forget('listTrademarks');

        if ($trademark) {
            return redirect()->route('backend.trademark.index')->with("success", 'Xóa thành công');
        } else {
            return redirect()->route('backend.trademark.index')->with("error", 'Xóa thất bại');
        }
    }

    public function export()
    {
        return Excel::download(new TrademarksExport(), 'trademarks.xlsx');
    }

    public function import(){
        Excel::import(new TrademarksImport(),request()->file('file'));

        return back();
    }
}
