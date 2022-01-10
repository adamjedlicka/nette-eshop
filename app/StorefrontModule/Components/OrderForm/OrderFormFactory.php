<?php

namespace App\StorefrontModule\Components\OrderForm;

interface OrderFormFactory
{
    public function create(): OrderForm;
}
