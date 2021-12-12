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

class CategoryPresenter extends BasePresenter
{
    private CategoriesFacade $categoriesFacade;

    private ProductsFacade $productsFacade;

    private FiltersControlFactory $filtersControlFactory;
    private ProductCartFormFactory $productCartFormFactory;

    public function __construct(
        CategoriesFacade $categoriesFacade,
        ProductsFacade $productsFacade,
        FiltersControlFactory $filtersControlFactory,
        ProductCartFormFactory $productCartFormFactory,
    )
    {
        parent::__construct();

        $this->categoriesFacade = $categoriesFacade;
        $this->productsFacade = $productsFacade;
        $this->filtersControlFactory = $filtersControlFactory;
        $this->productCartFormFactory = $productCartFormFactory;
    }

    public function actionView($slug, $values)
    {
        $category = $this->categoriesFacade->getCategoryBySlug($slug);
        $products = $this->productsFacade->getCategoryProducts($category, json_decode($values));

        $this->getFilters()->createSubcomponents($category, json_decode($values));

        $this->getFilters()->onSuccess[] = function ($values) use ($slug) {
            $this->redirect('view', $slug, json_encode($values));
        };

        $this->getComponent('productCartForm');

        $this->template->category = $category;
        $this->template->products = $products;
    }

    protected function createComponentFilters(): FiltersControl
    {
        return $this->filtersControlFactory->create();
    }

    protected function createComponentProductCartForm(): Multiplier
    {
        return new Multiplier(function ($productId) {
            /** @var CartControl $cart */
            $cart = $this->getComponent('cart');

            $product = $this->productsFacade->getProduct($productId);


            $form = $this->productCartFormFactory->create();
            $form->setDefaults(['id' => $product->id]);
            $form['quantity']->setHtmlAttribute('placeholder', 'Now in cart: '.$cart->getQuantityInCart($product));

            $form->onSubmit[] = function (ProductCartForm $form) use($cart, $product) {
                $quantity = $form->values->quantity;

                $cart->addToCart($product, $quantity);
                $this->flashMessage($product->name . ' has been added to cart ' . $quantity . ' times');
                $this->redirect('this');
            };

            return $form;
        });
    }

    private function getFilters(): FiltersControl
    {
        return $this->getComponent('filters');
    }
}
