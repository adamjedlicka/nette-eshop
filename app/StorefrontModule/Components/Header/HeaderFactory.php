<?php

namespace App\StorefrontModule\Components\Header;

use App\Model\Repositories\CategoryRepository;
use App\StorefrontModule\Components\CartControl\CartControlFactory;
use App\StorefrontModule\Components\Navigation\Navigation;
use App\StorefrontModule\Components\Navigation\NavigationFactory;

class HeaderFactory
{
    private CartControlFactory $cartControlFactory;
    private NavigationFactory $navigationFactory;

    public function __construct(
        CartControlFactory $cartControlFactory,
        NavigationFactory $navigationFactory
    )
    {
        $this->cartControlFactory = $cartControlFactory;
        $this->navigationFactory = $navigationFactory;
    }

    public function create(): Header
    {
        return new Header($this->cartControlFactory, $this->navigationFactory);
    }
}
