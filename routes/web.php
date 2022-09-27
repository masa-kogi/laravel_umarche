<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentTestController;
use App\Http\Controllers\lifeCycleTestController;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\GuestCartController;
use App\Http\Controllers\User\ItemReviewController;
use App\Http\Controllers\User\OrderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('user.welcome');
});


Route::get('/', [ItemController::class, 'index'])->name('items.index');
Route::get('show/{item}', [ItemController::class, 'show'])->name('items.show');

Route::prefix('items')
    ->middleware('auth:users')
    ->group(function () {
        Route::get('{item}/reviews', [ItemReviewController::class, 'index'])->name('items.reviews.index')->withoutMiddleware('auth:users');
        Route::get('{item}/reviews/create', [ItemReviewController::class, 'create'])->name('items.reviews.create');
        Route::post('{item}/reviews/store', [ItemReviewController::class, 'store'])->name('items.reviews.store');
        Route::get('{item}/reviews/{review}/edit', [ItemReviewController::class, 'edit'])->name('items.reviews.edit');
        Route::put('{item}/reviews/{review}', [ItemReviewController::class, 'update'])->name('items.reviews.update');
        Route::delete('{item}/reviews/{review}', [ItemReviewController::class, 'update'])->name('items.reviews.update');
    });


Route::prefix('cart')
    ->middleware('auth:users')
    ->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index')->withoutMiddleware('auth:users');
        Route::post('add', [CartController::class, 'add'])->name('cart.add');
        Route::post('delete/{item}', [CartController::class, 'delete'])->name('cart.delete');
        Route::get('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('success', [CartController::class, 'success'])->name('cart.success');
        Route::get('cancel', [CartController::class, 'cancel'])->name('cart.cancel');
    });

Route::prefix('guest.cart')
    ->group(function () {
        Route::get('/', [GuestCartController::class, 'index'])->name('guest.cart.index');
        Route::post('add', [GuestCartController::class, 'add'])->name('guest.cart.add');
        Route::post('delete/{item}', [GuestCartController::class, 'delete'])->name('guest.cart.delete');
        Route::get('checkout', [GuestCartController::class, 'checkout'])->name('guest.cart.checkout')->middleware('auth:users');
    });

// Route::resource('items.reviews', ItemReviewController::class)
//     ->middleware('auth:users');

Route::prefix('order')
    ->middleware('auth:users')
    ->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
    });
// Route::get('/dashboard', function () {
//     return view('user.dashboard');
// })->middleware(['auth:users'])->name('dashboard');

Route::get('/component-test1', [ComponentTestController::class, 'showComponent1']);
Route::get('/component-test2', [ComponentTestController::class, 'showComponent2']);
Route::get('/servicecontainertest', [lifeCycleTestController::class, 'showServiceContainerTest']);
Route::get('/serviceprovidertest', [lifeCycleTestController::class, 'showServiceProviderTest']);

require __DIR__ . '/auth.php';
