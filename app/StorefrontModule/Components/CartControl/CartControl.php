<?php

namespace App\StorefrontModule\Components\CartControl;

use App\Model\Entities\Cart;
use App\Model\Facades\CartsFacade;
use App\Model\Facades\UsersFacade;
use Exception;
use Nette\Application\UI\Control;
use Nette\Application\UI\Template;
use Nette\Http\Session;
use Nette\Security\User;

class CartControl extends Control
{
    private User $user;

    private CartsFacade $cartsFacade;

    private Cart $cart;

    public function __construct(User $user, Session $session, CartsFacade $cartsFacade, UsersFacade $usersFacade)
    {
        $this->user = $user;
        $this->cartsFacade = $cartsFacade;
        $cartSession = $session->getSection('cart');

        $cartId = $cartSession->get('cartId');
        try {
            $this->cart = $this->cartsFacade->getCartById($cartId);
            if ($user->isLoggedIn() && $this->cart->user->id != $user->id) {
                if ($this->cart->getTotalCount() > 0) {
                    $this->cartsFacade->deleteCartByUser($user->id);
                    $this->cart->user = $usersFacade->getUser($user->id);
                    $this->cartsFacade->saveCart($this->cart);
                }
            }
        } catch (Exception $e) {
            if ($user->isLoggedIn()) {
                try {
                    $this->cart = $this->cartsFacade->getCartByUser($user->id);
                    $cartSession->set('cartId', $this->cart->id);
                } catch (Exception $e) {
                    $this->cart = new Cart();
                    $this->cart->user = $usersFacade->getUser($user->id);
                    $this->cartsFacade->saveCart($this->cart);
                }
            }
        }

        if (!$this->cart) {
            $this->cart = new Cart();
            $this->cartsFacade->saveCart($this->cart);
        }
    }

    public function render($params = []): void
    {
        $template = $this->prepareTemplate('default');
        $template->render();
    }

    private function prepareTemplate(string $templateName = ''): Template
    {
        if (!empty($templateName)) {
            $this->template->setFile(__DIR__ . '/templates/' . $templateName . '.latte');
        }

        return $this->template;
    }
}
