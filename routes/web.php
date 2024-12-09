<?php

use App\Models\SubscriptionOffer;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/**
 * todo: delete this code here
 */

Route::get('/get-code/{phone}', function ($phone) {
    $verify = \App\Models\Verification::firstWhere('phone_number', $phone);
    if (!$verify)
        return response("invalid phone number", 400);
    return response($verify['code']);
});
