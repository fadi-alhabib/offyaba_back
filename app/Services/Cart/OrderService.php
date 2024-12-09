<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\OrderRepository;

class OrderService
{
    protected OrderRepository $orderRepository;
    protected CartRepository $cartRepository;

    public function __construct(OrderRepository $orderRepository, CartRepository $cartRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
    }

    public function getOrderForStore($storeId)
    {
        $orders = $this->orderRepository->getOrdersForStore($storeId);
        return $orders;
    }
    public function getOrdersForUser($userId)
    {
        $orders = $this->orderRepository->getOrdersForUser($userId);
        return $orders;
    }

    public function createOrderFromCart(Cart $cart, $location, $phoneNumber)
    {
        $order = $this->orderRepository->createOrderFromCart($cart, $location, $phoneNumber);

        $this->cartRepository->clearCart($cart->id);

        return $order;
    }

    public function acceptOrder($orderId)
    {
        return $this->orderRepository->updateStatus($orderId, Order::ACCEPTED);
    }

    public function cancelOrder($orderId)
    {
        return $this->orderRepository->updateStatus($orderId, Order::CANCELLED);
    }

    public function markAsDelivered($orderId)
    {
        return $this->orderRepository->updateStatus($orderId, Order::DELIVERED);
    }
}
