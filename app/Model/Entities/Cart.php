<?php

namespace App\Model\Entities;

use Dibi\DateTime;

/**
 * @property int $id
 * @property User $user m:hasOne
 * @property CartItem[] $items m:belongsToMany
 * @property DateTime $modified
 *
 * @method addToItems(CartItem $cartItem)
 * @method removeFromItems(CartItem $cartItem)
 * @method removeAllItems()
 */
class Cart extends BaseEntity
{
    public function getTotalCount(): int
    {
        if (empty($this->items)) return 0;

        $result = 0;

        foreach ($this->items as $item) {
            $result += $item->quantity;
        }

        return $result;
    }

    public function getTotalPrice(): int
    {
        if (empty($this->items)) return 0;

        $result = 0;

        foreach ($this->items as $item) {
            $result += $item->product->price * $item->quantity;
        }

        return $result;
    }
}
