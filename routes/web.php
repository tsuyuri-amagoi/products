<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use GuzzleHttp\Handler\Proxy;

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
    return view('auth.login');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//商品一覧ページ
Route::get('/index', [ProductsController::class, 'index'])->name('products.index');

//新規登録ページ
Route::get('/create', [ProductsController::class, 'create'])->name('products.create');

Route::post('/store', [ProductsController::class, 'store'])->name('products.store');

//商品詳細ページ
Route::get('/show/{id}', [ProductsController::class, 'show'])->name('products.show');

//商品編集ページ
Route::get('/edit/{id}', [ProductsController::class, 'edit'])->name('products.edit');

Route::put('/update/{id}', [Productscontroller::class, 'update'])->name('products.update');

//投稿削除機能
Route::delete('/destroy/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');