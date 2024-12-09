<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;

class OrderRepository
{


    public function find($id)
    {
        return Order::findOrFail($id);
    }

    public function getOrdersForStore($storeId)
    {
        return Order::where('store_id', $storeId)->with('items.item')->get();
    }

    public function getOrdersForUser($userId)
    {
        return Order::where('user_id', $userId)->with('items', 'store')->get();
    }

    public function create($attributes)
    {
        return Order::create($attributes);
    }

    public function createOrderFromCart(Cart $cart, $location, $phoneNumber)
    {
        $order = $this->create([
            'user_id' => $cart->user_id,
            'store_id' => $cart->store_id,
            'total' => $cart->total,
            'location' => $location,
            'phone' => $phoneNumber,
        ]);

        foreach ($cart->items as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $cartItem->item_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->item->price,
                'extra_notes' => $cartItem->extra_notes,
            ]);
        }
        return $order;
    }
    public function updateStatus($orderId, $status)
    {
        $order = $this->find($orderId);
        $order->status = $status;
        $order->save();
        return $order;
    }
}
