<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //truyền vào sidebar
        View::composer('client.includes.sidebar', function ($view) {
            $cates = Category::where('parent_id', null)->where('status',1)->get();
            $view->with('cates', $cates);
        });
        //
        View::composer('client.includes.header', function ($view) {
            $cartNumber = 0;
            if(Auth::check()){
                $cartNumber = Cart::where('user_id', Auth::user()->id)->count();
            }
            $view->with('cartNumber', $cartNumber);
        });

        //Truyền thông tin có đơn hàng mới vào sidebar manager
        View::composer('manager.includes.sidebar', function ($view) {
            $user = Auth::user();
            $store = $user->store;
            $orderNew = Order::where('store_id', $store->id)->where('status', 0)->count();
            // dd($orderNew);
            $view->with('orderNew', $orderNew);
        });
    }
}
