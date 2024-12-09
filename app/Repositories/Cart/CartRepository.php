<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\CartItem;

class CartRepository
{
    public function getCartByUserId($userId)
    {
        return Cart::with('items.item')->where('user_id', $userId)->first();
    }

    public function getCartItem($cartId, $itemId)
    {
        return CartItem::where('cart_id', $cartId)->where('item_id', $itemId)->first();
    }

    public function createCart($userId, $storeId)
    {
        return Cart::create(['user_id' => $userId, 'store_id' => $storeId, 'total' => 0]);
    }

    public function addItemToCart($cartId, $itemId, $quantity, $extraNotes = null)
    {
        $cartItem = CartItem::create([
            'cart_id' => $cartId,
            'item_id' => $itemId,
            'quantity' => $quantity,
            'extra_notes' => $extraNotes,
        ]);

        $this->updateCartTotal($cartId);

        return $cartItem;
    }

    public function updateCartItemQuantity($cartId, $itemId, $quantity, $extraNotes = null)
    {
        $cartItem = CartItem::where('cart_id', $cartId)->where('item_id', $itemId)->first();
        if ($cartItem) {
            $cartItem->quantity = $quantity;

            if ($extraNotes !== null) {
                $cartItem->extra_notes = $extraNotes;
            }

            $cartItem->save();
            $this->updateCartTotal($cartId);
        }
        return $cartItem;
    }

    public function removeItemFromCart($cartId, $itemId)
    {
        CartItem::where('cart_id', $cartId)->where('item_id', $itemId)->delete();
        $this->updateCartTotal($cartId);
    }

    private function updateCartTotal($cartId)
    {
        $cart = Cart::find($cartId);
        $total = $cart->items->sum(function ($cartItem) {
            return $cartItem->quantity * $cartItem->item->price;
        });
        $cart->total = $total;
        $cart->save();
    }

    public function clearCart($cartId)
    {
        CartItem::where('cart_id', $cartId)->delete();
        Cart::where('id', $cartId)->delete();
    }
}
