<?php

declare(strict_types = 1);

namespace App\StorefrontModule\Components\CartControl;

use Nette\Http\Session;
use Nette\Http\SessionSection;

class CartSession
{
    private const SESSION_ID = 'CART';
    private const CART_SESSION_KEY = 'CART_ID';

    private SessionSection $cartSession;

    public function __construct(
        Session $session
    )
    {
        $this->cartSession = $session->getSection(self::SESSION_ID);
    }

    public function hasCarId(): bool
    {
        return $this->cartSession->get(self::CART_SESSION_KEY) !== null;
    }

    public function getCartId(): int
    {
        return $this->cartSession->get(self::CART_SESSION_KEY);
    }

    public function setCartId(int $cartId): void
    {
        $this->cartSession->set(self::CART_SESSION_KEY, $cartId);
    }
}
