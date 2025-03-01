<?php

namespace App\View\Components;

use App\Facades\Cart;
use Closure;

use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use App\Repositaries\Cart\CartRepositary;

class CartList extends Component
{
    /**
     * Create a new component instance.
     */
    public $items;
    public $total;
    public function __construct()
    {
        $this->items = Cart::get();
        $this->total = Cart::total();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-list');
    }
}
