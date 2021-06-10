<?php

use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailsController;
use App\Http\Controllers\ReviewProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouriersController;
use App\Http\Controllers\Admin\ResponseController;
use App\Http\Controllers\Admin\ProductImagesController;
use App\Http\Controllers\Admin\TransactionAdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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


Auth::routes(['verify' => true]);

Route::middleware('auth')->group(function(){
    Route::get('sendEmaliVerif/{user:id}', [UserController::class, 'sendEmailVerif'])->name('send-email');

    //transaksi
    Route::get('detail-transaksi/{transactions:id}', [TransactionDetailsController::class, 'index'])->name('detail-transaksi');
    Route::get('transaksi', [TransactionController::class, 'index'])->name('transaksi');
    Route::put('upload-bukti/{transactions:id}', [TransactionController::class, 'update'])->name('upload-bukti');
    Route::put('cancel/{transactions:id}', [TransactionController::class, 'cancel'])->name('cancel');
    Route::put('verifikasi-barang/{transactions:id}', [TransactionController::class, 'verifbarang'])->name('verif-barang-diterima');

    //ongkir
    Route::post('cekongkir', [CheckoutController::class, 'cekongkir'])->name('cekongkir');
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('checkout-all', [CheckoutController::class, 'store'])->name('checkout-all');
    Route::get('getkota', [CheckoutController::class, 'getkota'])->name('getkota');

    //cart
    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::post('add-cart', [CartController::class, 'store'])->name('add-cart');
    Route::post('update-cart', [CartController::class, 'update'])->name('update-cart');
    Route::get('count-cart', [CartController::class, 'count'])->name('count-cart');
    Route::get('total-cart', [CartController::class, 'totalprice'])->name('total-cart');
    Route::delete('delete-cart', [CartController::class, 'destroy'])->name('delete-cart');
    Route::delete('delete/{cart:id}', [CartController::class, 'destroy'])->name('delete');


    //notification
    Route::get('count-notif', [MainController::class, 'counttotal'])->name("count-notif");
    Route::get('marksallread', [MainController::class, 'MarkAllRead'])->name("markread-notif-all");
    Route::get('/admin/marksallreadadmin', [DashboardController::class, 'MarkAllRead'])->name("markreadadmin-notif-all");
    Route::get('count-admin-notif', [DashboardController::class, 'counttotal'])->name("count-notif-admin");
    //product

    Route::post('beli', [MainController::class, 'store'])->name('beli-product');

    //user profile
    Route::get('profile',[UserController::class,'index'])->name('profile');
    Route::put('profile/update/{user:id}',[UserController::class,'update'])->name('profile.update');
    //review product
    Route::get('review-product/{product:id}', [ReviewProductController::class, 'index'])->name('review-product');
    Route::post('store-review', [ReviewProductController::class, 'store'])->name('store-review');
});

Route::get('/', [MainController::class, 'index'])->name('product');
Route::get('detail-product/{products:id}', [MainController::class, 'show'])->name('detail-product');
Route::get('filter-category', [MainController::class, 'categoryFilter'])->name('filter-category');
Route::get('filter-search', [MainController::class, 'searchFilter'])->name('filter-search');
Route::post('pagination/fetch', 'PaginationController@index')->name('pagination.fetch');




//admin
Route::group(['middleware' => ['auth:admin']],function(){

    //dashboard
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin');
    // admin profile
    Route::get('/admin/profile', [DashboardController::class, 'userProfile'])->name('admin.profile');
    Route::put('/admin/profile/update/{admin:id}', [DashboardController::class, 'update'])->name('admin.profile.update');

    //category
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('category');
    Route::post('/admin/category/add/store', [CategoryController::class, 'store'])->name('store-category');
    Route::put('/admin/category/update/{category:id}', [CategoryController::class, 'update'])->name('update-category');
    Route::delete('/admin/category/delete/{category:id}', [CategoryController::class, 'destroy'])->name('delete-category');

    //product
    Route::get('/admin/product', [ProductController::class, 'index'])->name('product');
    Route::get('/admin/product/add', [ProductController::class, 'create'])->name('add-product');
    Route::get('/admin/product/edit/{product:id}', [ProductController::class, 'edit'])->name('edit-product');
    Route::post('/admin/product/store', [ProductController::class, 'store'])->name('store-product');
    Route::put('/admin/product/update/{product:id}', [ProductController::class, 'update'])->name('update-product');
    Route::delete('/admin/product/destroy/{product:id}', [ProductController::class, 'destroy'])->name('destroy-product');
    Route::get('/admin/product/show/{product:id}', [ProductController::class, 'show'])->name('show-product');

    //product image
    Route::delete('/admin/product/productimage/destroy/{productImages:id}', [ProductImagesController::class, 'destroy'])->name('thumbnail-destroy');
    Route::post('/admin/product/productimage/store', [ProductImagesController::class, 'store'])->name('thumbnail-store');

    //discount admin
    Route::get('/admin/discount/{product:id}', [ProductController::class, 'discounts'])->name('discounts');
    Route::delete('/admin/discount/destroy/{discounts:id}', [ProductController::class, 'discounts_destroy'])->name('discounts-destroy');
    Route::put('/admin/discount/update/{discounts:id}', [ProductController::class, 'discounts_update'])->name('discounts-update');
    Route::post('/admin/discount/store', [ProductController::class, 'discounts_store'])->name('discounts-store');

    //kurir
    Route::get('/admin/couriers', [CouriersController::class, 'index'])->name('couriers');
    Route::delete('/admin/couriers/destroy/{couriers:id}', [CouriersController::class, 'destroy'])->name('couriers-destroy');
    Route::put('/admin/couriers/update/{couriers:id}', [CouriersController::class, 'update'])->name('couriers-update');
    Route::post('/admin/couriers/store', [CouriersController::class, 'store'])->name('couriers-store');

    Route::group(['middleware' => ['roles:super admin']], function () {
        //transaksi admin
        Route::get('/admin/transaksi', [TransactionAdminController::class, 'index'])->name('transaksi-admin');
        Route::get('/admin/transaksi/show/{transaction:id}', [TransactionAdminController::class, 'show'])->name('show-transaksi');
        Route::put('/admin/transaksi/update/{transaction:id}', [TransactionAdminController::class, 'update'])->name('update-transaksi');


        //report
        Route::post('/admin/transaksi/sort', 'TransactionController@sort');
        Route::post('/report-bulan', [DashboardController::class, 'filterBulan']);
        Route::post('/report-tahun',[DashboardController::class,'filterTahun']);
        Route::post('/grafik', [DashboardController::class,'grafik']);

        // Add Admin
        Route::get('/admin/add', [AdminUserController::class, 'index'])->name('admin.add');
        Route::get('/admin/create', [AdminUserController::class, 'create'])->name('admin.create');
        Route::post('/admin/store', [AdminUserController::class, 'store'])->name('admin.store');
        Route::get('/admin/edit/{admin:id}', [AdminUserController::class, 'edit'])->name('admin.edit');
        Route::put('/admin/update/{admin:id}', [AdminUserController::class, 'update'])->name('admin.update');
        Route::delete('/admin/destroy/{admin:id}', [AdminUserController::class, 'destroy'])->name('admin.destroy');
    });

    //respond
    Route::post('/admin/product/respond', [ResponseController::class, 'store'])->name('respond-product');
});
//login
Route::group(['middleware' => 'guest'], function(){
// Auth::routes admin;
Route::get('admin/login', [AdminAuthController::class, 'getLogin'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'postLogin']);
Route::get('admin/logout', [AdminAuthController::class, 'postLogout']);
});




