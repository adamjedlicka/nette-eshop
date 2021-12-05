<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\ProductEditForm\ProductEditForm;
use App\AdminModule\Components\ProductEditForm\ProductEditFormFactory;
use App\AdminModule\Components\ProductValueEditForm\ProductValueEditForm;
use App\AdminModule\Components\ProductValueEditForm\ProductValueEditFormFactory;
use App\Model\Facades\ProductsFacade;
use Exception;
use Tracy\Debugger;

class ProductPresenter extends BasePresenter
{
    private ProductsFacade $productsFacade;

    private ProductEditFormFactory $productEditFormFactory;

    private ProductValueEditFormFactory $productValueEditFormFactory;

    public function renderDefault()
    {
        $this->template->products = $this->productsFacade->findProducts();
    }

    public function actionValues(int $id)
    {
        $product = $this->productsFacade->getProduct($id);

        $this->getProductValueEditForm()->createSubcomponents($product);

        $this->template->product = $product;
    }

    public function actionDelete(int $id)
    {
        try {
            $product = $this->productsFacade->getProduct($id);
        } catch (Exception $e) {
            Debugger::log($e);
            $this->flashMessage('Product not found', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($product, 'delete')) {
            $this->flashMessage('This product cant be deleted', 'error');
            $this->redirect('default');
        }

        if ($this->productsFacade->deleteProduct($product)) {
            $this->flashMessage('Product was deleted', 'info');
        } else {
            $this->flashMessage('This product cant be deleted', 'error');
        }

        $this->redirect('default');
    }

    public function actionEdit(int $id)
    {
        try {
            $product = $this->productsFacade->getProduct($id);
        } catch (Exception $e) {
            Debugger::log($e);
            $this->flashMessage('Product not found', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($product, 'edit')) {
            $this->flashMessage('This product cannot be edited', 'error');
            $this->redirect('default');
        }

        $form = $this->getProductEditForm();
        $form->setDefaults($product);

        $this->template->product = $product;
    }

    public function createComponentProductEditForm(): ProductEditForm
    {
        $form = $this->productEditFormFactory->create();

        $form->onSuccess[] = function () {
            $this->redirect('default');
        };

        return $form;
    }

    public function createComponentProductValueEditForm(): ProductValueEditForm
    {
        $form = $this->productValueEditFormFactory->create();

        $form->onSuccess[] = function () {
            $this->redirect('default');
        };

        return $form;
    }

    private function getProductEditForm(): ProductEditForm
    {
        return $this->getComponent('productEditForm');
    }

    private function getProductValueEditForm(): ProductValueEditForm
    {
        return $this->getComponent('productValueEditForm');
    }

    public function injectProductsFacade(ProductsFacade $productsFacade)
    {
        $this->productsFacade = $productsFacade;
    }

    public function injectProductEditFormFactory(ProductEditFormFactory $productEditFormFactory)
    {
        $this->productEditFormFactory = $productEditFormFactory;
    }

    public function injectProductValueEditFormFactory(ProductValueEditFormFactory $productValueEditFormFactory)
    {
        $this->productValueEditFormFactory = $productValueEditFormFactory;
    }
}
