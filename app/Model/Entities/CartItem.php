<?php

namespace App\Model\Entities;

/**
 * @property int $id
 * @property Cart $cart m:hasOne
 * @property Product $product m:hasOne
 * @property int $quantity
 */
class CartItem extends BaseEntity
{
    public function addQuantity(int $quantitySurplus)
    {
        $this->quantity += $quantitySurplus;
    }
}
