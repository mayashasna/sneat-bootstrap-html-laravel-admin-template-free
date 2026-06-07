<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;

use App\Http\Controllers\Admin\Categories\CategoryController;
use App\Http\Controllers\Admin\Categories\SubcategoryController;
use App\Http\Controllers\BusinessAccount\BusinessAccountController;
use App\Http\Controllers\Api\User\ServiceController;
use App\Http\Controllers\Api\DynamicFieldController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ServiceOrderRatingController;
use App\Http\Controllers\Api\UserConversationController;
use App\Http\Controllers\Notification\NotificationController;
use App\Services\Notification\NotificationService as NotificationNotificationService;
// 🔥 هذا السطر ضروري جداً لتفعيل auth:api لمسار /api/broadcasting/auth


// ======================
//  Authentication Routes
// ======================
Route::post('register', [\App\Http\Controllers\Api\User\Auth\UserAuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Api\User\Auth\UserAuthController::class, 'login']);
Route::post('verify-otp', [\App\Http\Controllers\Api\User\Auth\UserAuthController::class, 'verifyOtp']);
Route::post('resend-otp', [\App\Http\Controllers\Api\User\Auth\UserAuthController::class, 'resendOtp']);


// ======================
//  Business Accounts
// ======================
Route::middleware('auth:api')->group(function () {

    Route::post('/business-accounts', [BusinessAccountController::class, 'store']);
    Route::get('/business-accounts', [BusinessAccountController::class, 'index']);
    Route::get('/business-accounts/{id}', [BusinessAccountController::class, 'show']);
    Route::post('/business-accounts/{id}/update', [BusinessAccountController::class, 'update']);
    Route::delete('/business-accounts/{id}', [BusinessAccountController::class, 'destroy']);
    Route::post('/business-accounts/{id}/restore', [BusinessAccountController::class, 'restore']);

});


// ======================
//  User Services
// ======================
Route::middleware('auth:api')->prefix('user')->group(function () {

    Route::post('/services', [ServiceController::class, 'store']);
    Route::post('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    Route::get('/services/trashed', [ServiceController::class, 'trashed']);
    Route::post('/services/restore/{id}', [ServiceController::class, 'restore']);
    Route::get('/services/filter', [ServiceController::class, 'filter']);

    Route::get('/services', [ServiceController::class, 'index']);
    Route::get('/services/{id}', [ServiceController::class, 'show']);
    Route::post('/services/{id}/order', [ServiceController::class, 'order']);
});


// ======================
//  Dynamic Fields
// ======================
Route::get('/dynamic-fields', [DynamicFieldController::class, 'byCategory']);


// ======================
//  Orders
// ======================
Route::prefix('orders')->group(function () {

    Route::post('/', [OrderController::class, 'store']);
    Route::get('sent', [OrderController::class, 'sent']);
    Route::get('received', [OrderController::class, 'received']);
    Route::post('{id}/accept', [OrderController::class, 'accept']);
    Route::post('{id}/reject', [OrderController::class, 'reject']);
});

Route::post('/orders/rate', [ServiceOrderRatingController::class, 'rate']);


// ======================
//  Notifications
// ======================
Route::middleware('auth:api')->get('/notifications', [NotificationController::class, 'index']);

Route::get('/test-notification', function () {
    $userId = auth('api')->id();

    app(NotificationNotificationService::class)->notifyUser(
        $userId,
        'notifications.new_order_title',
        'notifications.new_order_body',
        ['order_id' => 99],
        'new_order'
    );

    return response()->json(['message' => 'Test notification created']);
})->middleware('auth:api');


// ======================
//  Conversations
// ======================
Route::middleware('auth:api')->prefix('user')->group(function () {
    Route::post('/conversation/start', [UserConversationController::class, 'start']);
});


// ======================
//  Messaging (🔥 مهم جداً)
// ======================
Route::post('/user/conversation/{id}/message', [MessageController::class, 'send'])
    ->middleware('auth:api');


// ======================
//  Authenticated User
// ======================
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->post('/broadcasting/auth', function (Request $request) {
    return Broadcast::auth($request);
});
Route::post('/conversations/{conversationId}/read', [MessageController::class, 'markAsRead'])
    ->middleware('auth:api');


Route::middleware('auth:api')->get('/user/conversations', function (Request $request) {
    return response()->json([
        'status' => true,
        'data'   => $request->user()
            ->conversations()
            ->with(['participants', 'service', 'lastMessage'])
            ->orderByDesc('conversations.created_at')
            ->get()
    ]);
});




Route::middleware('auth:api')->group(function () {

    // Toggle favorite
    Route::post('/services/{id}/favorite', [\App\Http\Controllers\Api\ServiceFavoriteController::class, 'toggle']);

    // Get favorites list
    Route::get('/favorites', [\App\Http\Controllers\Api\ServiceFavoriteController::class, 'index']);

});

Route::middleware('auth:api')->group(function () {
    Route::post('/services/{id}/report', [ReportController::class, 'store']);
});
