<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[AuthController::class,'showtoppage'])->name('toppage');
// Route to load the login form
Route::get('/login',[AuthController::class,'showlogin'])->name('login');
// Route to load the register form
Route::get('/register',[AuthController::class,'showregister'])->name('register');

// route to handle form submission
Route::post('/register',[AuthController::class,'register'])->name('register.submit');

// route to handle the login form submissiom
Route::post('/login',[AuthController::class,'checklogin'])->name('login.submit');

// route to get the homepage
Route::get('/home',[AuthController::class,'showhomepage'])->middleware('auth')->name('homepage');

// route to get the account page
Route::get('/account',[AuthController::class,'showaccount'])->middleware('auth')->name('account');

// route to get the top page
Route::get('/top',[AuthController::class,'showtoppage'])->name('toppage');

// route to get the index page
Route::get('/index',[ProductController::class,'index'])->middleware('auth')->name('index');

// route to get the logout
Route::post('/logout',[AuthController::class,'logout'])->name('logout');

// route to get the purchases page
Route::get('/purchases',[AuthController::class,'purchases'])->middleware('auth')->name('purchases');



Route::middleware(['auth', 'admin'])->group(function () {
    // Product routes (admin-only)
    Route::get('/products/create', [ProductController::class, 'createproduct'])->name('create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

    // User management routes (admin-only)
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/admin/users/{id}/update', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Dashboard for admins
    Route::get('dashboard', [AuthController::class, 'showDashboard'])->name('dashboard');
});   

   


Route::post('/buy/{id}',[ProductController::class,'buyProduct'])->middleware('auth')->name('products.buy');

Route::post('/account/update', [AuthController::class, 'update'])->middleware('auth')->name('account.update');



Route::post('/admin/profile/{id}/update', [AuthController::class, 'updateProfilePicture'])->middleware('auth')->name('admin.profile.update');
