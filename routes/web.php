<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerAuthController;

//kode baru diubah menjadi seperti ini
Route::get('/', [HomepageController::class, 'index'])->name('home');
Route::get('products', [HomepageController::class, 'products']);
Route::get('product/{slug}', [HomepageController::class, 'product']);
Route::get('categories',[HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'category']);
Route::get('cart', [HomepageController::class, 'cart']);
Route::get('checkout', [HomepageController::class, 'checkout']);


Route::group(['prefix'=>'dashboard'], function(){
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');

    Route::resource('categories',ProductCategoryController::class);
    Route::resource('products', ProductController::class);

    // Route::get('products',[DashboardController::class,'products'])->name('products');


})->middleware(['auth', 'verified']);


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::group(['prefix'=>'customer'], function(){
 Route::controller(CustomerAuthController::class)->group(function(){
 //tampilkan halaman login
 Route::get('login','login')->name('customer.login');
 //aksi login
 Route::post('login','store_login')->name('customer.store_login');
 //tampilkan halaman register
 Route::get('register','register')->name('customer.register');
 //aksi register
 Route::post('register','store_register')->name('customer.store_register');
 //aksi logout
 Route::post('logout','logout')->name('customer.logout');
 });
});


require __DIR__.'/auth.php';
