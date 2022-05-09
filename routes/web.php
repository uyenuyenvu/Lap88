<?php

use Illuminate\Support\Facades\Route;

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

//==============Frontend===============
Route::group([
    'namespace' => 'Frontend',
    'prefix' => '/',
], function () {
    Route::get('/', 'HomeController@index')
        ->name('frontend.index');

    Route::get('product/{slug}', 'ProductController@show')
        ->name('frontend.product.show');

    Route::get('category/{slug}', 'CategoryController@show')
        ->name('frontend.category');

    //Giỏ hàng
    Route::get('cart', 'CartController@index')
        ->name('frontend.cart.index');

    Route::post('cart/add', 'CartController@add')
        ->name('frontend.cart.add');

    Route::post('/cart/increment', 'CartController@increment')
        ->name('frontend.cart.increment');

    Route::post('/cart/decrement', 'CartController@decrement')
        ->name('frontend.cart.decrement');

    Route::get('cart/remove/{id}', 'CartController@remove')
        ->name('frontend.cart.remove');

    Route::get('cart/destroy', 'CartController@destroy')
        ->name('frontend.cart.destroy');
    
   
        


    //Thanh toán
    Route::get('checkout', 'CheckoutController@index')
        ->name('frontend.checkout');

    Route::post('/', 'PayController@pay')
        ->name('frontend.pay');

    Route::post('payments/online', 'PayController@createPayment')
        ->name('payment.online');
    Route::get('vnpay/return', 'PayController@vnpayReturn')
        ->name('vnpay.return');

    //Tài khoản
    Route::get('account', 'UserController@edit')
        ->name('frontend.account');

    Route::match(['put', 'patch'], '/{id}', 'UserController@update')
        ->name('frontend.account.update');

    Route::post('order', 'UserController@order')
        ->name('frontend.order');

    Route::post('order-detail', 'UserController@orderDetail')
        ->name('frontend.order.detail');

    Route::post('huy-don-hang','UserController@huy_don_hang' )            
                ->name('frontend.order.huy-don-hang');


    //Tìm kiếm
    Route::get('/search', 'ProductController@search')
        ->name('frontend.product.search');

    Route::post('/autocomplete-ajax', 'ProductController@autocomplete_ajax')
        ->name('frontend.product.searchauto');
});
//=====================================


//=========Đăng nhập - Đăng ký=========
Route::get('login', 'Auth\LoginController@showLoginForm')
    ->name('login.form');

Route::get('login/admin', 'Auth\LoginController@showLoginFormAdmin')
    ->name('login');

Route::post('login', 'Auth\LoginController@login')
    ->name('login.store');

Route::get('logout', 'Auth\LogoutController@logout')
    ->name('logout');

Route::get('register', 'Auth\RegisterController@showRegisterForm')
    ->name('register.form');

Route::post('register', 'Auth\RegisterController@register')
    ->name('register.store');
//=====================================

//Reset mật khẩu
Route::post('send-mail-reset-password', 'Auth\ResetPasswordController@sendMail')
    ->name('reset.password.sendmail');

Route::get('confirm-reset-password', 'Auth\ResetPasswordController@formResetPassword');

Route::post('reset-password', 'Auth\ResetPasswordController@resetPassword')
    ->name('reset.password');

//===============Backend===============
Route::group([
    'namespace' => 'Backend',
    'prefix' => 'admin',
    'middleware' => ['auth', 'check_admin', 'preventBackHistory'],
], function () {
    // Dashboard
    Route::get('/', 'DashboardController@index')
        ->name('backend.dashboard');

    Route::post('/option', 'DashboardController@option')
        ->name('backend.option');

    // Quản lý sản phẩm
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', 'ProductController@index')
            ->name('backend.product.index');

        Route::get('/create', 'ProductController@create')
            ->name('backend.product.create');

        Route::post('/', 'ProductController@store')
            ->name('backend.product.store');

        Route::get('/filter', 'ProductController@filter')
            ->name('backend.product.filter');

        Route::get('/edit/{product}', 'ProductController@edit')
            ->name('backend.product.edit')
            ->middleware('can:update,product');

        Route::match(['put', 'patch'], '/{id}', 'ProductController@update')
            ->name('backend.product.update');

        Route::delete('/{product}', 'ProductController@destroy')
            ->name('backend.product.destroy')
            ->middleware('can:delete,product');

        Route::post('/get-trademark', 'ProductController@getTrademark')
            ->name('backend.product.trademark');

        //Export sản phẩm
        Route::get('/export-product', 'ProductController@export')
            ->name('backend.product.export');
        //Import sản phẩm
        Route::post('/import-product', 'ProductController@import')
            ->name('backend.product.import');
    });

    // Quản lý người dùng
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')
            ->name('backend.user.index');

        Route::get('/create', 'UserController@create')
            ->name('backend.user.create');

        Route::post('/', 'UserController@store')
            ->name('backend.user.store');

        Route::get('/{user}', 'UserController@show')
            ->name('backend.user.show');

        Route::get('/edit/{user}', 'UserController@edit')
            ->name('backend.user.edit')
            ->middleware('can:update,user');

        Route::match(['put', 'patch'], '/{id}', 'UserController@update')
            ->name('backend.user.update');

        Route::delete('/{user}', 'UserController@destroy')
            ->name('backend.user.destroy')
            ->middleware('can:delete,user');
    });
    //Export người dùng
    Route::get('/export-user', 'UserController@export')
        ->name('backend.user.export');
    //Import người dùng
    Route::post('/import-user', 'UserController@import')
        ->name('backend.user.import');


    // Quản lý danh mục
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoryController@index')
            ->name('backend.category.index');

        Route::get('/create', 'CategoryController@create')
            ->name('backend.category.create');

        Route::post('/', 'CategoryController@store')
            ->name('backend.category.store');

        Route::get('/edit/{category}', 'CategoryController@edit')
            ->name('backend.category.edit')
            ->middleware('can:update,category');

        Route::match(['put', 'patch'], '/{id}', 'CategoryController@update')
            ->name('backend.category.update');

        Route::delete('/{category}', 'CategoryController@destroy')
            ->name('backend.category.destroy')
            ->middleware('can:delete,category');

        //Export danh mục
        Route::get('/export-category', 'CategoryController@export')
            ->name('backend.category.export');
        //Import danh mục
        Route::post('/import-category', 'CategoryController@import')
            ->name('backend.category.import');
    });

    // Quản lý thương hiệu
    Route::group(['prefix' => 'trademark'], function () {
        Route::get('/', 'TrademarkController@index')
            ->name('backend.trademark.index');

        Route::get('/create', 'TrademarkController@create')
            ->name('backend.trademark.create');

        Route::post('/', 'TrademarkController@store')
            ->name('backend.trademark.store');

        Route::get('/edit/{trademark}', 'TrademarkController@edit')
            ->name('backend.trademark.edit')
            ->middleware('can:update,trademark');

        Route::match(['put', 'patch'], '/{id}', 'TrademarkController@update')
            ->name('backend.trademark.update');

        Route::delete('/{trademark}', 'TrademarkController@destroy')
            ->name('backend.trademark.destroy')
            ->middleware('can:delete,trademark');

        //Export thương hiệu
        Route::get('/export-trademark', 'TrademarkController@export')
            ->name('backend.trademark.export');
        //Import thương hiệu
        Route::post('/import-trademark', 'TrademarkController@import')
            ->name('backend.trademark.import');
    });

    //Quản lý đơn hàng
    Route::group(['prefix' => 'order'], function () {
        Route::get('/', 'OrderController@index')
            ->name('backend.order.index');

        Route::get('/show/{order}', 'OrderController@show')
            ->name('backend.order.show');

        Route::match(['put', 'patch'], '/{id}', 'OrderController@update')
            ->name('backend.order.update');

        Route::delete('/{order}', 'OrderController@destroy')
            ->name('backend.order.destroy');
        
        
    });

    //Quản lý nhà cung cấp
    Route::group(['prefix' => 'supplier'], function (){
        Route::get('/', 'SupplierController@index')
            ->name('backend.supplier.index');

        Route::get('/create', 'SupplierController@create')
            ->name('backend.supplier.create');

        Route::post('/', 'SupplierController@store')
            ->name('backend.supplier.store');

        Route::get('/{supplier}', 'SupplierController@show')
            ->name('backend.supplier.show');

        Route::get('/edit/{supplier}', 'SupplierController@edit')
            ->name('backend.supplier.edit');

        Route::match(['put', 'patch'], '/{id}', 'SupplierController@update')
            ->name('backend.supplier.update');

        Route::delete('/{supplier}', 'SupplierController@destroy')
            ->name('backend.supplier.destroy');
    });
    //Export nhà cung cấp
    Route::get('/export-supplier', 'SupplierController@export')
        ->name('backend.supplier.export');
    //Import nhà cung cấp
    Route::post('/import-supplier', 'SupplierController@import')
        ->name('backend.supplier.import');

    //Quản lý nhập hàng
    Route::group(['prefix' => 'purchase'], function (){
        Route::get('/create', 'PurchaseController@create')
            ->name('backend.purchase.create');

        Route::get('/show/{purchase}', 'PurchaseController@show')
            ->name('backend.purchase.show');

        Route::get('/cart', 'PurchaseController@cart')
            ->name('backend.purchase.cart');

        Route::post('cart/add', 'PurchaseController@add')
            ->name('backend.purchase.add');

        Route::post('/cart/increment', 'PurchaseController@increment')
            ->name('backend.purchase.increment');

        Route::post('/cart/decrement', 'PurchaseController@decrement')
            ->name('backend.purchase.decrement');

        Route::get('cart/remove/{id}', 'PurchaseController@remove')
            ->name('backend.purchase.remove');

        Route::get('cart/destroy', 'PurchaseController@destroyCart')
            ->name('backend.purchase.destroy.cart');

        Route::post('/get-product', 'PurchaseController@getProduct')
            ->name('backend.purchase.get.product');

        Route::get('order', 'PurchaseController@order')
            ->name('backend.purchase.order');

        Route::post('/', 'PurchaseController@store')
            ->name('backend.purchase.store');

        Route::match(['put', 'patch'], '/purchase/{id}', 'PurchaseController@update')
            ->name('backend.purchase.update');
    });

    //Quản lý kho
    Route::group(['prefix' => 'warehouse'], function (){
        Route::get('/', 'WarehouseController@index')
            ->name('backend.warehouse.index');
    });

    //Thống kê doanh thu
    Route::group(['prefix' => 'statistic'], function () {
        Route::get('/', 'StatisticController@index')
            ->name('backend.statistic.index');

        Route::post('/filte-by-date', 'StatisticController@filterByDate')
            ->name('backend.statistic.day');

        Route::post('/filte-option', 'StatisticController@filterOption')
            ->name('backend.statistic.option');

        //Export doanh thu
        Route::post('/export-statistic', 'StatisticController@export')
            ->name('backend.statistic.export');

        //Export sản phẩm trong kho
        Route::post('/export-statistic-warehouse', 'StatisticController@exportWarehouse')
            ->name('backend.statistic.export.warehouse');
    });
});
//=====================================


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
