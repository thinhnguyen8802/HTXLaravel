<?php

namespace App\Http\Controllers\BEController;

use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $provinces = Province::with('htxs')
        ->withCount('htxs')
        ->orderBy('htxs_count', 'desc')
        ->get();
        // dd($provinces);
        $storeCount = Store::count();
        $orderCount = Order::sum('total');
        $customerCount = User::where('role_id', 1)->count();
        $productCount = Product::count();
        return view('backend.page.dashboard',[
            'customerCount' => $customerCount,
            'storeCount' => $storeCount,
            'orderCount' => $orderCount,
            'productCount' => $productCount,
            'provinces' => $provinces,

        ]);
    }
}
