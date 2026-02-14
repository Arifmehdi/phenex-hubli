<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Auth\AuthController; // Import the newly created AuthController
use App\Http\Controllers\Api\ProductController; // Import ProductController
use App\Http\Controllers\Api\ProductCategoryController; // Import ProductCategoryController
use App\Http\Controllers\Api\CartController; // Import CartController
use App\Http\Controllers\Api\OrderController; // Import OrderController
use App\Http\Controllers\ChatController; // Import OrderController
use App\Http\Controllers\Api\UserController; // Import UserController
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);

// Public API routes for products and product categories (index and show will be public)
Route::apiResource('products', ProductController::class);
Route::get('products/{product}/overview', [ProductController::class, 'overview']); // New route for product overview
Route::get('products/{product}/no-description', [ProductController::class, 'withoutDescription']); // New route for product without description
Route::get('products-no-description', [ProductController::class, 'indexWithoutDescription']); // New route for all products without description
Route::get('products/by-slug/{slug}', [ProductController::class, 'getProductsBySlug']); // New route to get products by slug
Route::apiResource('product-categories', ProductCategoryController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/user', [ApiAuthController::class, 'me']);

    // Authenticated API routes for Cart and Orders
    Route::apiResource('cart', CartController::class)->only(['index', 'store', 'destroy']);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('users', UserController::class); // New Route for User management
    Route::patch('/user/profile', [UserController::class, 'updateMyProfile']);
    Route::patch('/user/password', [UserController::class, 'changePassword']);


    // routes/api.php
Route::get('/test-relationships', function() {
    $user = \App\Models\User::first();
    
    // Test 1: Check if user has conversations
    $conversations = $user->conversations;
    // dd('User conversations:', $conversations);
    
    // Test 2: Create a conversation
    $conversation = \App\Models\Conversation::create([
        'type' => 'private',
        'created_by' => $user->id
    ]);
    
    // Test 3: Add participants
    $participant = \App\Models\User::where('id', '!=', $user->id)->first();
    
    $cp = \App\Models\ConversationParticipant::create([
        'conversation_id' => $conversation->id,
        'user_id' => $participant->id,
        'is_admin' => false
    ]);
    
    dd('Created participant:', $cp);
});

        // Chat Routes
    Route::prefix('chat')->group(function () {


        Route::post('send', [ChatController::class, 'send']);
        Route::get('messages', [ChatController::class, 'messages']);
        Route::post('read', [ChatController::class, 'markAsRead']);
        // Conversations
        Route::get('conversations', [ChatController::class, 'getConversations']);
        Route::post('conversations', [ChatController::class, 'createConversation']);
        Route::get('conversations/{conversation}', [ChatController::class, 'getConversation']);
        Route::post('conversations/{conversation}/add-participant', [ChatController::class, 'addParticipant']);
        Route::delete('conversations/{conversation}/remove-participant/{user}', [ChatController::class, 'removeParticipant']);
        
        // Messages
        Route::get('conversations/{conversation}/messages', [ChatController::class, 'getMessages']);
        Route::post('conversations/{conversation}/messages', [ChatController::class, 'sendMessage']);
        Route::post('messages/{message}/read', [ChatController::class, 'markAsRead']);
        Route::delete('messages/{message}', [ChatController::class, 'deleteMessage']);
        
        // Users
        Route::get('users/search', [ChatController::class, 'searchUsers']);
        Route::get('users/{user}/conversation', [ChatController::class, 'getOrCreatePrivateConversation']);
    });
});



