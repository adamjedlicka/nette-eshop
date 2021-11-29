<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Facades\ProductsFacade;

class ProductPresenter extends BasePresenter
{
    private ProductsFacade $productsFacade;

    public function renderView($slug)
    {
        $this->template->product = $this->productsFacade->getProductBySlug($slug);
    }

    public function injectProductsFacade(ProductsFacade $productsFacade)
    {
        $this->productsFacade = $productsFacade;
    }
}
