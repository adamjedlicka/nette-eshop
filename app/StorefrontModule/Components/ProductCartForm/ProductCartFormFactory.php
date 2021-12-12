<?php

namespace App\StorefrontModule\Components\ProductCartForm;

interface ProductCartFormFactory
{
    public function create(): ProductCartForm;
}
