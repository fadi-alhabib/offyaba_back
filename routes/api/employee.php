<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QrCodeController;
use App\Notifications\SendPushNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Laravel\Firebase\Facades\Firebase;

/**
 * Prefix Here Should : api/employee
 *
 */


Route::prefix('/qr-code')
    ->middleware(['auth.any:employee'])
    ->controller(QrCodeController::class)
    ->group(function () {
        Route::post('/employee-scan', 'scan');
    });

Route::prefix('/orders')
    ->middleware('auth.any:employee')
    ->controller(OrderController::class)
    ->group(function () {
        Route::put('/{orderId}/accept', 'acceptOrder');
        Route::put('/{orderId}/cancel', 'cancelOrder');
        Route::put('/{orderId}/deliver', 'markAsDelivered');
        Route::get('/', 'getOrderForStore');
    });

Route::middleware('auth.any:employee')->post('/add-fcm-token', [EmployeeController::class, 'addFirebaseToken']);


Route::get('/notify', function () {
    $employee = Auth::guard('user-api')->user();
    $message = CloudMessage::fromArray([
        'topic' => "user",
        'notification' => [
            'title' => "From lara",
            'body' => "lara lara lara lara lara lara lara lara lara",
        ],
        'data' => [
            'to' => '/orders'
        ]
    ]);
    Firebase::messaging()->send($message);
    return response()->json(["message" => "successsssss"]);
});
