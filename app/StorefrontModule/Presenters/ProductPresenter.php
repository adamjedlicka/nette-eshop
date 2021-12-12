<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Entities\Product;
use App\Model\Facades\ProductsFacade;
use App\StorefrontModule\Components\CartControl\CartControl;
use App\StorefrontModule\Components\ProductCartForm\ProductCartForm;
use App\StorefrontModule\Components\ProductCartForm\ProductCartFormFactory;
use Nette\Application\UI\Multiplier;

class ProductPresenter extends BasePresenter
{
    private ProductsFacade $productsFacade;
    private ProductCartFormFactory $productCartFormFactory;

    private Product $currentProduct;

    public function __construct(
        ProductsFacade $productsFacade,
        ProductCartFormFactory $productCartFormFactory
    )
    {
        parent::__construct();

        $this->productsFacade = $productsFacade;
        $this->productCartFormFactory = $productCartFormFactory;
    }

    public function renderView($slug)
    {
        $product = $this->productsFacade->getProductBySlug($slug);
        $this->template->product = $product;
        $this->currentProduct = $product;


        $this->getComponent('productCartForm');
    }

    protected function createComponentProductCartForm(): ProductCartForm
    {
        /** @var CartControl $cart */
        $cart = $this->getComponent('cart');

        $product = $this->currentProduct; //Typed property App\StorefrontModule\Presenters\ProductPresenter::$currentProduct must not be accessed before initialization

        $form = $this->productCartFormFactory->create();
        $form->setDefaults(['id' => $product->id]);
        $form['quantity']->setHtmlAttribute('placeholder', 'Now in cart: ' . $cart->getQuantityInCart($product));

        $form->onSubmit[] = function (ProductCartForm $form) use ($cart, $product) {
            $quantity = $form->values->quantity;

            $cart->addToCart($product, $quantity);
            $this->flashMessage($product->name . ' has been added to cart ' . $quantity . ' times');
            $this->redirect('this');
        };

        return $form;
    }

}
