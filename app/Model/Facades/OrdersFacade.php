<?php

namespace App\Model\Facades;

use App\Model\Entities\Cart;
use App\Model\Entities\CartItem;
use App\Model\Entities\Order;
use App\Model\Entities\User;
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
    public function getOrders(User $user): array
    {
        return $this->orderRepository->findAllBy(['user_id' => $user->id, 'order' => 'created_at DESC']);
    }

    public function markOrderPaid(int $orderId)
    {
        /** @var Order $order */
        $order = $this->orderRepository->find($orderId);
        $order->paidAt = new \DateTimeImmutable();
        $this->orderRepository->persist($order);
    }

    public function markOrderSent(int $orderId)
    {
        /** @var Order $order */
        $order = $this->orderRepository->find($orderId);
        $order->shippedAt = new \DateTimeImmutable();
        $this->orderRepository->persist($order);
    }

    public function create(
        Cart $cart,
        string $name,
        string $email,
        string $phone,
        string $street,
        string $city,
        string $zip,
        string $country
    ): void
    {
        $order = new Order();
        $order->createdAt = new DateTime();
        $order->paidAt = null;
        $order->serializedContent = $this->serializeCartItems($cart->cartItems);

        $order->name = $name;
        $order->email = $email;
        $order->phone = $phone;
        $order->street = $street;
        $order->city = $city;
        $order->zip = $zip;
        $order->country = $country;

        if ($cart->user !== null) {
            $order->user = $cart->user;
        }

        $this->orderRepository->persist($order);

    }

    /** @param CartItem[] $cartItems */
    private function serializeCartItems(array $cartItems)
    {
        return json_encode(
            array_map(
                function (CartItem $cartItem) {
                    return [
                        'id' => $cartItem->product->id,
                        'name' => $cartItem->product->name,
                        'price' => $cartItem->product->price,
                        'quantity' => $cartItem->quantity,
                    ];
                },
                $cartItems
            )
        );
    }

}
