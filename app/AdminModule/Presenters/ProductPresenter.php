<?php

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\ProductEditForm\ProductEditForm;
use App\AdminModule\Components\ProductEditForm\ProductEditFormFactory;
use App\Model\Facades\ProductsFacade;
use Exception;

class ProductPresenter extends BasePresenter
{
    private ProductsFacade $productsFacade;

    private ProductEditFormFactory $productEditFormFactory;

    public function renderDefault()
    {
        $this->template->products = $this->productsFacade->findProducts();
    }

    public function actionDelete(int $id)
    {
        try {
            $product = $this->productsFacade->getProduct($id);
        } catch (Exception $e) {
            $this->flashMessage('Product not found', 'error');
            $this->redirect('default');
            return;
        }

        if (!$this->user->isAllowed($product, 'delete')) {
            $this->flashMessage('This product cant be deleted', 'error');
            $this->redirect('default');
            return;
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
            $this->flashMessage('Product not found', 'error');
            $this->redirect('default');
        }

        if (!$this->user->isAllowed($product, 'edit')) {
            $this->flashMessage('This product cannot be edited', 'error');
            $this->redirect('default');
        }

        $form = $this->createComponentProductEditForm();
        $form = $form->setDefaults($product);
        dump($form);

        $this->template->product = $product;
        $this->template->productEditForm = $form;
    }

    public function createComponentProductEditForm(): ProductEditForm
    {
        $form = $this->productEditFormFactory->create();

        $form->onSuccess[] = function () {
            $this->redirect('default');
        };

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
