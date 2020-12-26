<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;


// Membership

Route::middleware('rank:0')->group(function () {
    Route::get('/home', [UserController::class, 'user']);
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::get('/subscription', [SubscriptionController::class, 'index']);
    Route::post('/profile', [ProfileController::class, 'store']);
});

// Admin
Route::middleware('rank:1')->group(function () {
    Route::get('/admin', [UserController::class, 'admin'])->name('admin');

    Route::post('/admin', [SubscriptionController::class, 'checkSubscription'])->name('process');

    Route::redirect('/admin/member', '/admin');

    Route::get('/admin/subscription', [SubscriptionController::class, 'manage_subscription'])->name('subscription');

    Route::post('/admin/subscription/add', [SubscriptionController::class, 'add_new_subscription'])->name('add_new_subscription');

    Route::get('/admin/subscription/delete/{id}', [SubscriptionController::class, 'delete_subscription'])->name('delete_subscription');

    Route::post('/admin/subscription/edit/{id}', [SubscriptionController::class, 'edit_subscription'])->name('edit_subscription');

    Route::get('/admin/subscription/edit/{id}', [SubscriptionController::class, 'view_subscription'])->name('view_subscription');

    Route::view('/admin/member/add', 'admin.add_member')->name('member_add_view');

    Route::post('/admin/member/add', [UserController::class, 'add_member'])->name('member_add');

    Route::post('/admin/member/edit', [UserController::class, 'edit_member'])->name('member_edit');

    Route::get('/admin/member/{id}', [UserController::class, 'view_member'])->name('member_view');

    Route::post('/admin/member/delete/{id}', [UserController::class, 'delete_member'])->name('member_delete');

    Route::get('/admin/member/subscription/trial', [SubscriptionController::class, 'trial_membership'])->name('trial_membership');

    Route::get('/admin/member/subscription/{id}', [UserController::class, 'subscription_member'])->name('member_subs');

    Route::post('/admin/member/subscription/add', [SubscriptionController::class, 'addSubscription'])->name('add_subscription');
});

// Auth

Route::post('/signup', [RegisterController::class, 'register'])->name('register');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

// End Auth

// Checkout

Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

Route::get('/checkout', [CheckoutController::class, 'checkout']);

Route::post('/success', [CheckoutController::class, 'success'])->name('gateway');

// End Checkout

Route::get('/', function () {
    return view('home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/login', function () {
    return view('login');
});