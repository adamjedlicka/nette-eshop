<?php

namespace App\StorefrontModule\Components\Header;

use Nette\Application\UI\Control;

class Header extends Control
{
    private $categories;

    public function __construct($categories)
    {
        $this->categories = $categories;
    }

    public function render(): void
    {
        $this->template->categories = $this->categories;
        $this->template->render(__DIR__ . '/header.latte');
    }
}
