<?php

namespace App\Services\Cart;

use App\Models\Item;
use App\Repositories\Cart\CartRepository;

class CartService
{
    protected CartRepository $cartRepository;
    protected OrderService $orderService;

    public function __construct(CartRepository $cartRepository, OrderService $orderService)
    {
        $this->cartRepository = $cartRepository;
        $this->orderService = $orderService;
    }

    public function getCart($userId)
    {
        $cart = $this->cartRepository->getCartByUserId($userId);

        if (!$cart) {
            $cart = $this->cartRepository->createCart($userId, null);
        }

        return $cart;
    }

    public function addItem($userId, $itemId, $quantity, $extraNotes = null)
    {
        // $item = Item::find($itemId);
        $item = Item::find($itemId);
        $cart = $this->getCart($userId);

        if ($cart->store_id && $cart->store_id !== $item->store_id) {
            $this->cartRepository->clearCart($cart->id);
            $cart = $this->cartRepository->createCart($userId, $item->store_id);
        } elseif (!$cart->store_id) {
            $cart->store_id = $item->store_id;
            $cart->save();
        }

        $cartItem = $this->cartRepository->getCartItem($cart->id, $itemId);

        if ($cartItem) {

            $newQuantity = $cartItem->quantity + $quantity;
            return $this->cartRepository->updateCartItemQuantity($cart->id, $itemId, $newQuantity);
        } else {

            return $this->cartRepository->addItemToCart($cart->id, $itemId, $quantity, $extraNotes);
        }
    }

    public function addClothingItem($userId, $itemId, $quantity)
    {
        // $item = Item::find($itemId);
        $item = Item::find($itemId);
        $cart = $this->getCart($userId);

        if ($cart->store_id && $cart->store_id !== $item->store_id) {
            $this->cartRepository->clearCart($cart->id);
            $cart = $this->cartRepository->createCart($userId, $item->store_id);
        } elseif (!$cart->store_id) {
            $cart->store_id = $item->store_id;
            $cart->save();
        }

        $cartItem = $this->cartRepository->getCartItem($cart->id, $itemId);

        if ($cartItem) {

            $newQuantity = $cartItem->quantity + $quantity;
            return $this->cartRepository->updateCartItemQuantity($cart->id, $itemId, $newQuantity);
        } else {

            return $this->cartRepository->addItemToCart($cart->id, $itemId, $quantity);
        }
    }

    public function clearCart($cartId)
    {
        $this->cartRepository->clearCart($cartId);
    }

    public function checkoutCart($userId, $location, $phoneNumber)
    {
        $cart = $this->cartRepository->getCartByUserId($userId);

        if (!$cart) {
            throw new \Exception("Cart not found for user with ID: {$userId}");
        }

        $order = $this->orderService->createOrderFromCart($cart, $location, $phoneNumber);

        return $order;
    }

    public function removeItem($userId, $itemId)
    {
        $cart = $this->getCart($userId);
        if ($cart->items->count() === 1) {
            return $this->clearCart($cart->id);
        }
        return $this->cartRepository->removeItemFromCart($cart->id, $itemId);
    }
}
