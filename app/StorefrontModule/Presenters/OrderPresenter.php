<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Facades\OrdersFacade;
use App\StorefrontModule\Components\OrderForm\OrderForm;
use App\StorefrontModule\Components\OrderForm\OrderFormFactory;
use App\StorefrontModule\Components\ProductCartForm\ProductCartForm;
use Nette\Security\User;

class OrderPresenter extends BasePresenter
{
    private OrdersFacade $ordersFacade;
    private User $currentUser;
    private OrderFormFactory $orderFormFactory;

    public function __construct(
        OrdersFacade $ordersFacade,
        User $currentUser,
        OrderFormFactory $orderFormFactory
    ) {
        parent::__construct();

        $this->ordersFacade = $ordersFacade;
        $this->currentUser = $currentUser;
        $this->orderFormFactory = $orderFormFactory;
    }

    public function renderCreate()
    {
    }

    public function renderView()
    {
        $this->template->orders = $this->ordersFacade->getOrders($this->currentUser->getId());
    }

    protected function createComponentOrderForm(): OrderForm
    {
        $form = $this->orderFormFactory->create();
//        $form->setDefaults(['id' => $product->id]);
//        $form['quantity']->setHtmlAttribute('placeholder', 'Now in cart: ' . $cart->getQuantityInCart($product));
//
//        $form->onSubmit[] = function (ProductCartForm $form) use ($cart, $product) {
//            $quantity = $form->values->quantity ?? 1;
//
//            $cart->addToCart($product, $quantity);
//            $this->flashMessage($product->name . ' has been added to cart ' . $quantity . ' times');
//            $this->redirect('this');
//        };

        return $form;
    }
}
