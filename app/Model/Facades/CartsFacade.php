<?php

namespace App\Model\Facades;

use App\Model\Entities\Cart;
use App\Model\Entities\CartItem;
use App\Model\Entities\User;
use App\Model\Repositories\CartItemRepository;
use App\Model\Repositories\CartRepository;
use Dibi\DateTime;
use Exception;

class CartsFacade
{
    private CartRepository $cartRepository;

    private CartItemRepository $cartItemRepository;

    public function __construct(
        CartRepository $cartRepository,
        CartItemRepository $cartItemRepository,
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartItemRepository = $cartItemRepository;
    }

    public function getCartById(?int $id): Cart
    {
        return $this->cartRepository->find($id);
    }

    /**
     * @param User|int $user
     */
    public function getCartByUser($user): Cart
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        return $this->cartRepository->findBy(['userId', $user]);
    }

    public function saveCartItem(CartItem $cartItem)
    {
        $this->cartItemRepository->persist($cartItem);
    }

    public function saveCart(Cart $cart)
    {
        $cart->modified = new DateTime();
        $this->cartRepository->persist($cart);
    }

    public function deleteCartByUser($user)
    {
        if ($user instanceof User) {
            $user = $user->id;
        }

        try {
            $this->cartRepository->delete($this->getCartByUser($user));
        } catch (Exception $e) {
            // Do nothing...
        }
    }
}
