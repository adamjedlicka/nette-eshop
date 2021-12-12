<?php

namespace App\StorefrontModule\Components\CartControl;

interface CartControlFactory
{
    public function create(): CartControl;
}
