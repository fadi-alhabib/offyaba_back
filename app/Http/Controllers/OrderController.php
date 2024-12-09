<?php

namespace App\Http\Controllers;

use App\Services\Cart\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getOrderForStore(Request $request)
    {
        try {
            $orderId = $request->user()->store->id;
            $orders = $this->orderService->getOrderForStore($orderId);
            return $this->success($orders);
        } catch (\Throwable $th) {
            return $this->failed($th->getMessage());
        }
    }

    public function getOrdersForUser(Request $request)
    {
        $userId = $request->user()->id;
        $orders = $this->orderService->getOrdersForUser($userId);
        return $this->success($orders);
    }

    public function acceptOrder(Request $request, $orderId)
    {
        try {
            $order = $this->orderService->acceptOrder($orderId);
            return $this->success($order);
        } catch (\Exception $e) {
            return $this->failed($e->getMessage(), 500);
        }
    }

    public function cancelOrder(Request $request, $orderId)
    {
        try {
            $order = $this->orderService->cancelOrder($orderId);
            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function markAsDelivered(Request $request, $orderId)
    {
        try {
            $order = $this->orderService->markAsDelivered($orderId);
            return response()->json($order);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
