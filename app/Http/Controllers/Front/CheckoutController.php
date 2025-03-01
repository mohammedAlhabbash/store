<?php

namespace App\Http\Controllers\Front;

use App\Facades\Cart;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Catch_;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('fornt-pages.checkout', [
            'countries' => Countries::getNames(),
        ]);
    }
    public function store(Request $request)
    {
        // dd($request);
        // $request->validate([
        //     ''
        // ])
        $items = Cart::get()->groupBy('product.store_id');
        // dd($items);
        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'user_id' => Auth::user(),
                    'store_id' => $store_id,
                    // 'status' => $request->staus,
                    'payment_method' => 'cod',
                    // 'payment_status' => $request->payment_status
                ]);
                foreach ($cart_items as $cart) {
                    OrderProduct::create([
                        'product_id' => $cart->product_id,
                        'order_id' => $order->id,
                        'product_name' => $cart->product->name,
                        'price' => $cart->product->price,
                        'quantity' => $cart->quantity
                    ]);
                }
            }
            foreach ($request->addr as $type => $address) {
                $address['type'] = $type;
                $order->addresses()->create($address);
            }
            db::commit();
            
        } catch (Throwable $t) {
            DB::rollBack();
            throw $t;
        }
        return redirect()->route('home');
    }
}
