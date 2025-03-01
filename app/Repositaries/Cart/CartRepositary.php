<?php

namespace App\Repositaries\Cart;

use Illuminate\Support\Collection;

interface CartRepositary
{
    public function get(): Collection;
    public function add($id, $quantity = 1);
    public function update($id, $quantity);
    public function delete($id);
    public function empty();
    public function total(): float;
}
