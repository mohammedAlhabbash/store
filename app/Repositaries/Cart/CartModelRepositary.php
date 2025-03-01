<?php

namespace App\Repositaries\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartModelRepositary implements CartRepositary
{
    public $items;
    public function __construct()
    {
        $this->items = collect([]);
    }
    public function get(): Collection
    {

        if (!$this->items->count()) {
            $this->items = Cart::with('product')->Where('cookie_id', '=', $this->getCookieId())->where('user_id', Auth::id())->get();
        }
        return $this->items;

        // return
        // Cart::with('product')->where('user_id', Auth::id())->get();
        // // dd($items);
    }
    public function add($id, $quantity = 1)
    {
        $check = Cart::where('user_id', Auth::id())->Where('cookie_id', '=', $this->getCookieId())->Where('product_id', $id)->first();
        if (!$check) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'cookie_id'=>$this->getCookieId(),
                'product_id' => $id,
                'quantity' => $quantity
            ]);
            return $this->get()->push($cart);
        }
        return $check->increment('quantity', $quantity);
    }
    public function update($id, $quantity)
    {
        Cart::where('id', $id)->update([
            'quantity' => $quantity
        ]);
    }
    public function delete($id)
    {
        $cart = Cart::where('user_id', Auth::id())->Where('cookie_id', '=', $this->getCookieId())->Where('product_id', $id)->first();
        if ($cart) {
            $cart->delete();
        }
    }
    public function empty()
    {
        Cart::query()->destroy();
    }
    public function total(): float
    {
        // return (float) Cart::where('user_id', Auth::id())
        //     ->orWhere('cookie_id', $this->getCookieId())
        //     ->join('products', 'products.id', '=', 'carts.product_id')
        //     ->selectRaw('SUM(carts.quantity * products.price) as total')
        //     ->value('total');
        // dd($this->items->sum(function(){

        // }));
        $total = $this->get();
        return (float)$total->sum(function ($total) {
            return $total->quantity * $total->product->price;
        });
    }
    protected  function getCookieId()
    {
        $cookie = Cookie::get('cart');
        if (!$cookie) {
            $cookie = Str::uuid();
            Cookie::queue('cart', $cookie, 30 * 24 * 60);
        }
        return $cookie;
    }
}
