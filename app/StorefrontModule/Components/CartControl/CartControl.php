<?php

namespace App\StorefrontModule\Components\CartControl;

use App\Model\Entities\Cart;
use App\Model\Entities\CartItem;
use App\Model\Entities\Product;
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
    private Cart $cart;
    private CartControlFacade $cartControlFacade;

    public function __construct(
        User $authenticatedUser,
        CartControlFacade $cartControlFacade
    )
    {
        $cart = $cartControlFacade->resolveCart($authenticatedUser);

        $cartControlFacade->saveCartForUser($cart, $authenticatedUser);

        $this->cart = $cart;
        $this->user = $authenticatedUser;
        $this->cartControlFacade = $cartControlFacade;
    }

    public function render($params = []): void
    {
        $template = $this->prepareTemplate('default');
        $template->cart = $this->cart;
        $template->render();
    }

    public function renderList($params = []): void
    {
        $template = $this->prepareTemplate('list');
        $template->cart = $this->cart;
        $template->render();
    }

    public function addToCart(Product $product, int $quantity)
    {
        $this->cartControlFacade->addProductToCart($this->cart, $product, $quantity);
    }

    public function getQuantityInCart(Product $product): int
    {
        return $this->cartControlFacade->getCountInCart($this->cart, $product);
    }

    private function prepareTemplate(string $templateName = ''): Template
    {
        if (!empty($templateName)) {
            $this->template->setFile(__DIR__ . '/templates/' . $templateName . '.latte');
        }

        return $this->template;
    }
}
