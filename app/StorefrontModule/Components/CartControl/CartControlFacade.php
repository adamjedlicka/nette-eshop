<?php

namespace App\StorefrontModule\Components\CartControl;

use App\Model\Entities\Cart;
use App\Model\Entities\CartFactory;
use App\Model\Entities\CartItem;
use App\Model\Entities\CartItemFactory;
use App\Model\Entities\Product;
use App\Model\Facades\CartsFacade;
use App\Model\Facades\UsersFacade;
use Exception;
use Nette\Application\UI\Control;
use Nette\Application\UI\Template;
use Nette\Http\Session;
use Nette\Security\User;

class CartControlFacade
{
    private CartSession $cartSession;

    private CartsFacade $cartsFacade;
    private UsersFacade $usersFacade;

    private CartFactory $cartFactory;
    private CartItemFactory $cartItemFactory;

    public function __construct(
        CartSession $cartSession,
        CartsFacade $cartsFacade,
        UsersFacade $usersFacade,
        CartFactory $cartFactory,
        CartItemFactory $cartItemFactory,
    )
    {
        $this->cartsFacade = $cartsFacade;
        $this->cartSession = $cartSession;
        $this->usersFacade = $usersFacade;
        $this->cartFactory = $cartFactory;
        $this->cartItemFactory = $cartItemFactory;
    }

    public function resolveCart(User $authenticatedUser): Cart
    {
        if ($this->cartSession->hasCarId() === true) {
            try {
                return $this->cartsFacade->getCartById($this->cartSession->getCartId());
            } catch (Exception $e) {
                //pass
            }
        }

        if ($authenticatedUser->isLoggedIn() === true) {
            try {
                return $this->cartsFacade->getCartByUser($authenticatedUser->getId());
            } catch (Exception $e) {
                //pass
            }
        }

        $cart = $this->cartFactory->createCart();
        $this->cartsFacade->saveCart($cart);

        return $cart;
    }

    public function saveCartForUser(Cart $cart, User $authenticatedUser): void
    {
        if ($authenticatedUser->isLoggedIn() === true) {
            $cart->user = $this->usersFacade->getUser($authenticatedUser->getId());
            $this->cartsFacade->saveCart($cart);
        }

        $this->cartSession->setCartId($cart->id);
    }

    public function addProductToCart(Cart $cart, Product $product, int $quantity)
    {

        if ($cart->hasItemWithProduct($product) === true) {
            $cartItem = $cart->getItemWithProduct($product);
        } else {
            $cartItem = $this->cartItemFactory->createWithProduct($cart, $product);
        }

        $cartItem->addQuantity($quantity);

//        $cart->addToItems($cartItem);
        $cart->updateCartItems();

        $this->cartsFacade->saveCartItem($cartItem);
        $this->cartsFacade->saveCart($cart);
    }

    public function getCountInCart(Cart $cart, Product $product): int
    {
        if ($cart->hasItemWithProduct($product) === true) {
            return $cart->getItemWithProduct($product)->quantity;
        }

        return 0;
    }

}
