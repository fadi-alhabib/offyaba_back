<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddItemToCartRequest;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function show(Request $request)
    {
        $userId = $request->user()->id;
        $cart = $this->cartService->getCart($userId);

        return $this->success($cart);
    }

    public function addItem(AddItemToCartRequest $request)
    {
        $itemData = $request->only(['item_id', 'quantity', 'price', 'extra_notes']);
        $userId = $request->user()->id;

        $cartItem = $this->cartService->addItem($userId, $itemData["item_id"], $itemData["quantity"], $itemData['extra_notes']);
        return $this->success($cartItem);
    }

    public function removeItem(Request $request, $itemId)
    {
        $userId = $request->user()->id;
        $this->cartService->removeItem($userId, $itemId);
        // return response()->json(['message' => 'Item removed from cart']);
        return $this->success(null, "", 204);
    }

    public function checkout(Request $request)
    {
        $userId = $request->user()->id;

        try {
            $validatedData = $request->validate([
                'location' => 'required|string',
                'phone' => 'required|string',

            ]);
            $order = $this->cartService->checkoutCart($userId, $validatedData['location'], $validatedData['phone']);
            return $this->success($order);
        } catch (\Exception $e) {
            // return response()->json(['error' => $e->getMessage()], 500);
            return $this->failed($e->getMessage(), 500);
        }
    }

    public function clearCart(Request $request)
    {
        try {
            $cartId = $request->user()->cart->id;
            $this->cartService->clearCart($cartId);
            return $this->success(null, "", 204);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage(), 400);
        }
    }
}
