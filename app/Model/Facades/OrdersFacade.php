<?php

namespace App\Model\Facades;

use App\Model\Entities\Cart;
use App\Model\Entities\CartItem;
use App\Model\Entities\Order;
use App\Model\Repositories\OrderRepository;
use Dibi\DateTime;

class OrdersFacade
{
    private OrderRepository $orderRepository;

    public function __construct(
        OrderRepository $orderRepository
    )
    {
        $this->orderRepository = $orderRepository;
    }

    /** @return Order[] */
    public function getOrders(int $userId): array
    {
        return $this->orderRepository->findAllBy(['user' => $userId]);
    }

    public function createFromCart(Cart $cart): void
    {
        $order = new Order();

        $order->user = $cart->user;
        $order->createdAt = new DateTime();
        $order->paidAt = null;
        $order->serializedContent = $this->serializeCartItems($cart->cartItems);

    }

    /** @param CartItem[] $cartItems */
    private function serializeCartItems(array $cartItems)
    {
        return json_encode($cartItems);
    }

}
