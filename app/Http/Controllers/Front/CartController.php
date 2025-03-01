<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositaries\Cart\CartRepositary;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $cart;
    public function __construct(CartRepositary $cart)
    {
        $this->cart = $cart;
    }
    public function index()
    {
        $items['all'] = $this->cart->get();
        $items['total'] = $this->cart->total();
        // dd($items);
        return view('fornt-pages.cart', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => ['required', 'int', 'exists:products,id'],
            'quantity' => ['required', 'int', 'min:1'],
        ]);
        $this->cart->add($request->product_id, $request->quantity);
        return redirect()->route('carts.index');
    }

    public function update(Request $request, string $id)
    {
        // dd($request);
        // $request->validate([
        //     // 'id' => ['required', 'int'],
        //     'quantity' => ['required', 'int', 'min:1'],
        // ]);
        // dd($request);
        $this->cart->update($id, $request->quantity);
        return response()->json([
            'data' => $request->quantity
        ]);
        // return redirect()->route('carts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd('mohammed');
        $this->cart->delete($id);
        return [
            'message' => 'items deleted!'
        ];
    }
}
