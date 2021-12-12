<?php

declare(strict_types = 1);

namespace App\Model\Entities;

class CartItemFactory
{
    public function createWithProduct(Cart $cart, Product $product)
    {
        $cartItem = new CartItem();
        $cartItem->cart = $cart;
        $cartItem->product = $product;
        $cartItem->quantity = 0;

        return $cartItem;
    }
}
