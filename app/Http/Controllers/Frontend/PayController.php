<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\SendMail;
use App\Models\Order;
use App\Models\Product;
use App\Models\Statistic;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Helpers\function;
use App\Models\Order_Product;
use App\Models\Transaction;
use Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Session\Session;



class PayController extends Controller
{
    
    public function pay(Request $request){
        
        $data = $request->except('_token');
        
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 0;
        $data['type'] = $request -> type;
        
        $items = Cart::content(); // lấy dữ liệu trong order_product
       
        
        if($request ->type ==2){
            $totalMoney =str_replace(',','', Cart::total(0));
            session(['info_custormer' => $data]);
            return view('frontend/pages/vnpay/index', compact('totalMoney'));
        } else {
        foreach ($items as $item){
            $order = Order::create($data);
            $order->products()->attach($item->id, [
                'name'          => $item->name,
                'price'         => $item->price,
                'quantity'      => $item->qty,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
        }

        $details = [
            'order_id'  => $order->id,
            'date'      => Carbon::now()->format('d-m-Y'),
            'total'     => Cart::total(),
            'name'      => $order->name,
            'phone'     => $order->phone,
            'address'   => $order->address,
            'qty'       => Cart::count(),
            'products'  => $items,
            
        ];

        Cart::destroy();

        \Mail::to(Auth::user()->email)->send(new SendMail($details));


        if ($order){
            alert()->success('Đặt hàng thành công', 'Vui lòng kiểm tra đơn hàng hoặc email');
        } else {
            alert()->error('Đặt hàng thất bại', 'Vui lòng thử lại');
        }
        
        return redirect()->route('frontend.index');
    }
}
    public function createPayment(Request $request){
        
        $vnp_TxnRef = randString(15);
        $vnp_OrderInfo = $request->order_desc;
        $vnp_OrderType = "Thanh toán";
        $vnp_Amount = str_replace(',', '', Cart::total()) * 100;
        $vnp_Locale = $request->language;
        $vnp_BankCode = $request->bank_code;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
// Tạo input data để lưu các thông tin bên trên vào data
    $inputData = array(
        "vnp_Version" => "2.0.0",
        "vnp_TmnCode" => env('VNP_TMN_CODE'),
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $vnp_IpAddr,
        "vnp_Locale" => $vnp_Locale,
        "vnp_OrderInfo" => $vnp_OrderInfo,
        "vnp_OrderType" => $vnp_OrderType,
        "vnp_ReturnUrl" => route('vnpay.return'),
        "vnp_TxnRef" => $vnp_TxnRef,
    );
    
    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
    }
    ksort($inputData);
    $query = "";
    $i = 0;
    $hashdata = "";
    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . $key . "=" . $value;
        } else {
            $hashdata .= $key . "=" . $value;
            $i = 1;
        }
        $query .= urlencode($key) . "=" . urlencode($value) . '&';
    }
    // dd($query);
    $vnp_Url = env('VNP_URL') . "?" . $query;
    if (env('VNP_HASH_SECRET')) {
    // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
        $vnpSecureHash = hash('sha256', env('VNP_HASH_SECRET') . $hashdata);
        $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
    }
    return redirect($vnp_Url);
    }


    /*public function vnpayReturn(Request $request){
        if(session()->has('info_custormer') && $request->vnp_ResponseCode == '00'){
            
            DB::beginTransaction();
            try {
                $vnpayData = $request->all();
                $data = session()->get('info_custormer');
                
                // $transactionID = Transaction::insertGetId($data);
                 $orderID  = Order::latest()->first()->id;
                  //dd($orderID);
                if($orderID){
                    $shopping = Cart::content();
                    //  dd($shopping);
                    foreach($shopping as $key => $item){
                        // Luu chi tiet don hang
                    //    $order_product =new Order_Product();
                    //    $order_product->order_id = $orderID;
                    //    $order_product->product_id = $item->id;
                    //    $order_product->name = $item->name;
                    //    $order_product->price = $item->price;
                    //    $order_product->quantity = $item->qty;
                    //    $order_product ->save();

                    //    $order_product = Order_Product::insert([
                    //         'order_id' => $orderID,
                    //         'product_id' => $item->id,
                    //         'name' => $item->name,
                    //         'price' => $item->price,
                    //         'quantity' => $item->qty,
                    //     ]);
                    foreach ($items as $item){
                        $order->products()->attach($item->id, [
                            'name'          => $item->name,
                            'price'         => $item->price,
                            'quantity'      => $item->qty,
                            'created_at'    => Carbon::now(),
                            'updated_at'    => Carbon::now()
                        ]);
                        dd($order_product);
                        DB::table('products')->where('id', $item->id)->increment("slug");
                    }
                
                    $dataPayment = [
                        'order_id' => $orderID,
                        'p_transaction_code' => $vnpayData['vnp_TxnRef'],
                        'user_id' => $data['user_id'],
                        'p_money' => $data['total_price'],
                        'p_note' => $vnpayData['vnp_OrderInfo'],
                        'p_vnp_response_code' => $vnpayData['vnp_ResponseCode'],
                        'p_code_vnpay' => $vnpayData['vnp_TransactionNo'],
                        'p_code_bank'=> $vnpayData['vnp_BankCode'],
                        'p_time'=> date('Y-m-d H:i', strtotime($vnpayData['vnp_PayDate'])),
                        
                    ];
                    
                    Payment::insert($dataPayment);
                }
                $request->session()->flash('message', 'Đơn hàng của bạn đã được lưu');
                // \Session::flash('toastr',[
                //     'type' => 'success',
                //     'message' => 'Đơn hàng của bạn đã được lưu'
                // ]);
                
                \Session::destroy();
                \DB::commit();
                return view('fronted/pages/vnpay/nvpay_return', compact('vnpayData'));
            } catch (\Exception $exception) {
                $request->session()->flash('message', 'Đã xày ra lỗi không thể thanh toán đơn hàng');
                // \Session::flash('toastr', [
                //     'type' => 'error',
                //     'message' => 'Đã xày ra lỗi không thể thanh toán đơn hàng'
                // ]);
                \DB::rollBack();
                //return redirect()->to('/');
            }
    }else{
        \Session::flash('toasrt',[
            'type' =>'error',
            'message' => 'Đã xảy ra lỗi không thể thanh toán đơn hàng'
        ]);
        
        //return redirect()->to('/');
    }
}*/

public function vnpayReturn(Request $request){
    $data = session()->get('info_custormer');
    $vnpayData = $request->all();
    
    $items = Cart::content(); // lấy dữ liệu trong order_product
    $order = Order::create($data);// lấy dữ liệu trong order
    $orderID  = Order::latest()->first()->id;
 
    foreach ($items as $item){
        $order->products()->attach($item->id, [
            'name'          => $item->name,
            'price'         => $item->price,
            'quantity'      => $item->qty,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
    }
    $details = [
        'order_id'  => $order->id,
        'date'      => Carbon::now()->format('d-m-Y'),
        'total'     => Cart::total(),
        'name'      => $order->name,
        'phone'     => $order->phone,
        'address'   => $order->address,
        'qty'       => Cart::count(),
        'products'  => $items,
    ];

    $dataPayment = [
        'order_id' => $orderID,
        // 'date'      => Carbon::now()->format('d-m-Y'),
        // 'p_transaction_code' => $vnpayData['vnp_TxnRef'],
        'user_id' => $data['user_id'],
        'p_money' => $data['total_price'],
        'p_note' => $vnpayData['vnp_OrderInfo'],
        'p_vnp_response_code' => $vnpayData['vnp_ResponseCode'],
        'p_code_vnpay' => $vnpayData['vnp_TransactionNo'],
        'p_code_bank'=> $vnpayData['vnp_BankCode'],
        'p_time'=> date('Y-m-d H:i', strtotime($vnpayData['vnp_PayDate'])),
        
    ];
    Payment::insert($dataPayment);
    Cart::destroy();

    \Mail::to(Auth::user()->email)->send(new SendMail($details));


    if ($order){
        alert()->success('Đặt hàng thành công', 'Vui lòng kiểm tra đơn hàng hoặc email');
    } else {
        alert()->error('Đặt hàng thất bại', 'Vui lòng thử lại');
    }
    
    return redirect()->route('frontend.index');
}
}


