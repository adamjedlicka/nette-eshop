<?php

namespace App\StorefrontModule\Components\Header;

use App\StorefrontModule\Components\CartControl\CartControl;
use App\StorefrontModule\Components\CartControl\CartControlFactory;
use App\StorefrontModule\Components\Navigation\Navigation;
use App\StorefrontModule\Components\Navigation\NavigationFactory;
use Nette\Application\UI\Control;

class Header extends Control
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

    public function render(): void
    {
        $this->template->render(__DIR__ . '/header.latte');
    }

    protected function createComponentCart(): CartControl
    {
        return $this->cartControlFactory->create();
    }

    protected function createComponentNavigation(): Navigation
    {
        return $this->navigationFactory->create();
    }
}
