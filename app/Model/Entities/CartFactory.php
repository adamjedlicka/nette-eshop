<?php

declare(strict_types = 1);

namespace App\Model\Entities;

class CartFactory
{
    public function createCart()
    {
        return new Cart();
    }
}
