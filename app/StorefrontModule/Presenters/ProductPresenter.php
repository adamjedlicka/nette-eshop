<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Entities\Product;
use App\Model\Facades\ProductsFacade;
use App\StorefrontModule\Components\CartControl\CartControl;
use App\StorefrontModule\Components\ProductCartForm\ProductCartForm;
use App\StorefrontModule\Components\ProductCartForm\ProductCartFormFactory;

class ProductPresenter extends BasePresenter
{
    private ProductsFacade $productsFacade;
    private ProductCartFormFactory $productCartFormFactory;

    private Product $currentProduct;

    public function __construct(
        ProductsFacade $productsFacade,
        ProductCartFormFactory $productCartFormFactory
    ) {
        parent::__construct();

        $this->productsFacade = $productsFacade;
        $this->productCartFormFactory = $productCartFormFactory;
    }

    public function actionView($slug)
    {
        $this->currentProduct = $this->productsFacade->getProductBySlug($slug);
    }

    public function renderView()
    {
        $this->template->product = $this->currentProduct;
    }

    protected function createComponentProductCartForm(): ProductCartForm
    {
        /** @var CartControl $cart */
        $cart = $this->getComponent('cart');

        $product = $this->currentProduct;

        $form = $this->productCartFormFactory->create();
        $form->setDefaults(['id' => $product->id]);
        $form['quantity']->setHtmlAttribute('placeholder', 'Now in cart: ' . $cart->getQuantityInCart($product));

        $form->onSubmit[] = function (ProductCartForm $form) use ($cart, $product) {
            $quantity = $form->values->quantity ?? 1;

            $cart->addToCart($product, $quantity);
            $this->flashMessage($product->name . ' has been added to cart ' . $quantity . ' times');
            $this->redirect('this');
        };

        return $form;
    }
}
