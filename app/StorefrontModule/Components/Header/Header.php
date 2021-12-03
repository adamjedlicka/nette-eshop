<?php

namespace App\StorefrontModule\Components\Header;

use App\StorefrontModule\Components\CartControl\CartControl;
use App\StorefrontModule\Components\CartControl\CartControlFactory;
use Nette\Application\UI\Control;

class Header extends Control
{
    private $categories;

    private CartControlFactory $cartControlFactory;

    public function __construct($categories, CartControlFactory $cartControlFactory)
    {
        $this->categories = $categories;
        $this->cartControlFactory = $cartControlFactory;
    }

    public function render(): void
    {
        $this->template->categories = $this->categories;
        $this->template->render(__DIR__ . '/header.latte');
    }

    protected function createComponentCart(): CartControl
    {
        return $this->cartControlFactory->create();
    }
}
