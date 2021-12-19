<?php

namespace App\StorefrontModule\Presenters;

use App\StorefrontModule\Components\CartControl\CartControl;
use App\StorefrontModule\Components\CartControl\CartControlFactory;
use App\StorefrontModule\Components\Header\Header;
use App\StorefrontModule\Components\Header\HeaderFactory;
use App\StorefrontModule\Components\Navigation\NavigationFactory;
use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{
    private HeaderFactory $headerFactory;

    private CartControlFactory $cartControlFactory;

    private NavigationFactory $navigationFactory;

    public function beforeRender()
    {
        parent::beforeRender();

        $this->redrawControl('title');
        $this->redrawControl('content');
    }

    protected function createComponentHeader(): Header
    {
        return $this->headerFactory->create();
    }

    protected function createComponentCart(): CartControl
    {
        return $this->cartControlFactory->create();
    }

    public function injectHeaderFactory(HeaderFactory $headerFactory)
    {
        $this->headerFactory = $headerFactory;
    }

    public function injectCartControlFactory(CartControlFactory $cartControlFactory)
    {
        $this->cartControlFactory = $cartControlFactory;
    }

    public function injectNavigationFactory(NavigationFactory $navigationFactory)
    {
        $this->navigationFactory = $navigationFactory;
    }
}
