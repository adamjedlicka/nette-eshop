<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\ProductEditForm\ProductEditForm;
use App\AdminModule\Components\ProductEditForm\ProductEditFormFactory;
use App\Model\Facades\ProductsFacade;

class ProductPresenter extends BasePresenter
{
    private ProductsFacade $productsFacade;

    private ProductEditFormFactory $productEditFormFactory;

    public function renderDefault()
    {
        $this->template->products = $this->productsFacade->findProducts();
    }

    public function createComponentProductEditForm(): ProductEditForm
    {
        $form = $this->productEditFormFactory->create();

        return $form;
    }

    public function injectProductsFacade(ProductsFacade $productsFacade)
    {
        $this->productsFacade = $productsFacade;
    }

    public function injectProductEditFormFactory(ProductEditFormFactory $productEditFormFactory)
    {
        $this->productEditFormFactory = $productEditFormFactory;
    }
}
