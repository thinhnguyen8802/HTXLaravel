<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FEController\ApiController;

use App\Http\Controllers\BEController\AuthController;
use App\Http\Controllers\BEController\UserController;
use App\Http\Controllers\FEController\HomeController;
use App\Http\Controllers\BEController\StoreController;
use App\Http\Controllers\BEController\BannerController;
use App\Http\Controllers\MController\ManagerController;
use App\Http\Controllers\MController\ProductController;
use App\Http\Controllers\BEController\CategoryController;
use App\Http\Controllers\BEController\QuestionController;
use App\Http\Controllers\BEController\DashboardController;

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
Route::get('/register',[AuthController::class, 'viewRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register');

Route::get('/login',[AuthController::class, 'viewLogin'])->name('login');
Route::post('/login',[AuthController::class, 'login'])->name('login');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');

Route::middleware([
    'auth:sanctum',
    'verified'
])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/', [DashboardController::class, "index"])->name('admin.dashboard');
        Route::resource('users', UserController::class);
        Route::resource('stores', StoreController::class);
        Route::resource('banners', BannerController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('questions', QuestionController::class);

    });

    Route::prefix('/manager')->group(function () {
        Route::resource('products', ProductController::class);
        Route::get('/',[ManagerController::class, 'index'])->name('manager.index');
        Route::get('/statistical',[ManagerController::class, 'statistical'])->name('statistical');
        Route::post('/filter-by-date',[ManagerController::class, 'filter_by_date']);
        Route::get('/orders',[ManagerController::class, 'orders'])->name('manager.orders');
        Route::get('/order/{id}',[ManagerController::class, 'editOrder'])->name('manager.editOrder');
        Route::patch('/order/{id}',[ManagerController::class, 'updateOrder'])->name('manager.updateOrder');
        Route::get('/editShop',[ManagerController::class, 'editShop'])->name('manager.editShop');
        Route::patch('/editShop',[ManagerController::class, 'updateShop'])->name('manager.editShop');


    });

    Route::get('/profile',[HomeController::class, 'profile'])->name('profile');

});

Route::get('/',[HomeController::class, 'index'])->name('home');
Route::get('/blog/{id}',[HomeController::class, 'blog'])->name('blog');
Route::get('/htx/{id}',[HomeController::class, 'htx'])->name('htx');
Route::get('/products',[HomeController::class, 'searchResult'])->name('search.result');
Route::get('/product/{id}',[HomeController::class, 'productDetail'])->name('product.detail');
Route::get('/cart',[HomeController::class, 'cart'])->name('home.cart');
Route::get('/payment',[HomeController::class, 'payment'])->name('home.payment');
Route::get('/thankyou',[HomeController::class, 'thankyou'])->name('thankyou');



Route::prefix('/api')->group(function () {
    Route::post('/get-revenue',[ApiController::class, 'getRevenue']);
    Route::post('/buy-now',[ApiController::class, 'buyNow'])->name('buyNow');
    Route::post('/add-to-cart',[ApiController::class, 'addToCart']);
    Route::post('/update-cart',[ApiController::class, 'updateCart']);
    Route::post('/update-status-cart',[ApiController::class, 'changeStatusCart']);
    Route::post('/update-shipping',[ApiController::class, 'updateShipping']);
    Route::get('/get-data-shipping/{id}',[ApiController::class, 'getDataShipping']);
    Route::get('/get-shippings',[ApiController::class, 'getShippings']);
    Route::post('/get-list-order',[ApiController::class, 'getListOrder']);
    Route::get('/view-order',[ApiController::class, 'viewOrder']);
    Route::get('/cancel-order',[ApiController::class, 'cancelOrder']);
    Route::get('/vnpay-return', [ApiController::class, 'vnpayReturn'])->name('vnpay.return');
    Route::get('/momo-return', [ApiController::class, 'momoReturn'])->name('momo.return');

    
    Route::post('/order',[ApiController::class, 'order'])->name('api.create_order');

    Route::get('/provinces', [ApiController::class, 'getProvinces']);
    Route::get('/districts/{province_id}', [ApiController::class, 'getDistrictsByProvince']);
    Route::get('/wards/{district_id}', [ApiController::class, 'getWardsByDistrict']);
    Route::get('/get-name-province', [ApiController::class, 'getNameProvince'])->name("nameProvince");
    Route::get('/get-name-district', [ApiController::class, 'getNameDistrict'])->name("nameDistrict");
    Route::get('/get-name-wards', [ApiController::class, 'getNameWards'])->name("nameWards");
    Route::get('/get-name-wards', [ApiController::class, 'getNameWards'])->name("nameWards");
    Route::post('/update-user',[ApiController::class, 'updateUser']);
    Route::post('/change-password',[ApiController::class, 'changePassword']);

    Route::post('/registerStore',[ApiController::class, 'registerStore'])->name('api.registerStore');
    Route::PATCH('/approve-request',[ApiController::class, 'approveRequest'])->name('api.approveRequest');


});
