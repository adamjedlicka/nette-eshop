<?php

namespace App\StorefrontModule\Presenters;

use App\Model\Facades\OrdersFacade;
use App\Model\Facades\UsersFacade;
use App\StorefrontModule\Components\CartControl\CartControlFacade;
use App\StorefrontModule\Components\OrderForm\OrderForm;
use App\StorefrontModule\Components\OrderForm\OrderFormFactory;
use App\StorefrontModule\Components\ProductCartForm\ProductCartForm;
use Nette\Security\User;

class OrderPresenter extends BasePresenter
{
    private OrdersFacade $ordersFacade;
    private User $currentUser;
    private OrderFormFactory $orderFormFactory;
    private CartControlFacade $cartControlFacade;
    private UsersFacade $usersFacade;

    public function __construct(
        OrdersFacade $ordersFacade,
        User $currentUser,
        OrderFormFactory $orderFormFactory,
        CartControlFacade $cartControlFacade,
        UsersFacade $usersFacade
    )
    {
        parent::__construct();

        $this->ordersFacade = $ordersFacade;
        $this->currentUser = $currentUser;
        $this->orderFormFactory = $orderFormFactory;
        $this->cartControlFacade = $cartControlFacade;
        $this->usersFacade = $usersFacade;
    }

    public function actionCreate()
    {
        $formDefaultValues = ['cartId' => $this->cartControlFacade->resolveCart($this->currentUser)->id];

        if ($this->currentUser->isLoggedIn()) {
            $appUser = $this->usersFacade->getUser($this->currentUser->getId());
            $formDefaultValues['name'] = $appUser->name;
            $formDefaultValues['email'] = $appUser->email;
        }

        $form = $this->getComponent('orderForm');
        $form->setDefaults($formDefaultValues);

        $form->onSubmit[] = function () {
            $this->redirect('finished');
        };
    }

    public function renderFinished()
    {
    }

    public function renderList()
    {
        if($this->currentUser->isLoggedIn()){
            $appUser = $this->usersFacade->getUser($this->currentUser->getId());
            $this->template->orders = $this->ordersFacade->getOrders($appUser);
        } else{
            $this->template->orders = [];
        }
    }

    protected function createComponentOrderForm(): OrderForm
    {
        return $this->orderFormFactory->create();
    }
}
