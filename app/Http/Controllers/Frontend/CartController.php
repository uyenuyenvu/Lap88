<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::content();
        return view('frontend.pages.cart')->with([
            'items' => $items
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $product = Product::find($data['id']);
        $qua = Cart::add($product->id, $product->name, 1, $product->sale_price, 0, [
            'slug'      => $product->slug,
            'image'     => $product->images[0]->image_url,
            'cost'      => $product->origin_price,
            'quantity'  => $product->quantity,
        ]);
        if ($qua->qty > $qua->options->quantity){
            Cart::update($qua->rowId, $qua->qty - 1);
        } else {
            echo $data = json_encode($qua);
        }
    }

    public function increment(Request $request)
    {
        $cart = Cart::get($request->rowId);
        if ($cart->qty < $cart->options->quantity){
            Cart::update($request->rowId, $cart->qty + 1);
            echo $data = json_encode($cart);
        } else {
            echo $data;
        }
    }

    public function decrement(Request $request)
    {
        $cart = Cart::get($request->rowId);
        Cart::update($request->rowId, $cart->qty - 1);
        echo $data = json_encode($cart);
    }

    public function remove($cart_id)
    {
        Cart::remove($cart_id);
        return redirect()->route('frontend.cart.index');
    }

    public function destroy()
    {
        Cart::destroy();
        return redirect()->route('frontend.cart.index');
    }
}
