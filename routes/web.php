<?php

use App\Http\Controllers\ProfileController as ProfileOfAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PurchaseController;

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

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('dashboard', [UserItemController::class, 'userCreate'])->name('dashboard');
    Route::get('item-details{id}',[UserItemController::class,'itemDetails'])->name('item.details');

    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::post('cart{item_id}', [CartController::class, 'addCart'])->name('cart.add');

    Route::get('cart{id}', [CartController::class, 'delete'])->name('cart.delete');
    

    
    Route::get('/payment', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/store', [PaymentController::class, 'store'])->name('store');
    
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.create');



    
    });

    require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->group(function(){
    

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
        Route::get('/profile', [ProfileOfAdminController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileOfAdminController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileOfAdminController::class, 'destroy'])->name('profile.destroy');
        
    });

    require __DIR__.'/admin.php';
});
