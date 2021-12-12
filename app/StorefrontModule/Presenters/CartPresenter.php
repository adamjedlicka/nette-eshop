<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Facades\CategoriesFacade;
use App\Model\Facades\ProductsFacade;
use App\StorefrontModule\Components\CartControl\CartControl;
use App\StorefrontModule\Components\FiltersControl\FiltersControl;
use App\StorefrontModule\Components\FiltersControl\FiltersControlFactory;
use App\StorefrontModule\Components\ProductCartForm\ProductCartForm;
use App\StorefrontModule\Components\ProductCartForm\ProductCartFormFactory;
use Nette\Application\UI\Multiplier;

class CartPresenter extends BasePresenter
{
    private CartControl $cartControl;

    public function actionView()
    {
    }

}
