<?php

namespace App\Model\Entities;

use Dibi\DateTime;

/**
 * @property int $id
 * @property User $user m:hasOne
 * @property CartItem[] $cartItems m:belongsToMany
 * @property DateTime $modified
 *
 * @method addToItems(CartItem $cartItem)
 * @method removeFromItems(CartItem $cartItem)
 * @method removeAllItems()
 */
class Cart extends BaseEntity
{
    public function updateCartItems()
    {
        $this->row->cleanReferencedRowsCache(
            'cart_item'
        ); //smažeme cache, aby se položky v košíku znovu načetly z DB bez nutnosti načtení celého košíku
    }

    public function getTotalCount(): int
    {
        $result = 0;

        foreach ($this->cartItems as $item) {
            $result += $item->quantity;
        }

        return $result;
    }

    public function getTotalPrice(): int
    {
        $result = 0;

        foreach ($this->cartItems as $item) {
            $result += $item->product->price * $item->quantity;
        }

        return $result;
    }

    public function hasItemWithProduct(Product $product): bool
    {
        foreach ($this->cartItems as $cartItem) {
            if ($cartItem->product->id === $product->id) {
                return true;
            }
        }

        return false;
    }

    public function getItemWithProduct(Product $product): CartItem
    {
        foreach ($this->cartItems as $cartItem) {
            if ($cartItem->product->id === $product->id) {
                return $cartItem;
            }
        }

        throw new \Exception('no cart item with product ' . $product->id);
    }
}
