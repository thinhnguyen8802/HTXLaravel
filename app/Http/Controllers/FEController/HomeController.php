<?php

namespace App\Http\Controllers\FEController;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Store;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Question;
use App\Models\Shipping;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index()
    {
        $stores = Store::get();
        $products = Product::where("status", 1)->get();
        $topProducts = OrderDetail::select('order_details.product_id', DB::raw('SUM(order_details.quantity) as total_quantity'))
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('products.status', 1)
            ->groupBy('order_details.product_id')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();
        $banners = Banner::get();
        $questions = Question::get();

        return view('client.page.index', [
            'stores'=> $stores,
            'products'=> $products,
            'banners'=> $banners,
            'questions'=> $questions,
            'topProducts'=> $topProducts,
        ]);
    }
    public function blog(string $id){
        $blog = Question::find($id);
        return view('client.page.blog',[
            'blog'=> $blog,
        ]);
    }
    public function htx(string $id){
        $htx = Store::find($id);
        return view('client.page.htx',[
            'htx'=> $htx,
        ]);
    }

    public function searchResult(Request $request)
    {
        $data = $request->all();

        $query = Product::where("status", 1);
        // Lọc theo danh mục
        if ($request->has('cate_id') && $request->input('cate_id') != null) {
            $cate_id = $request->input('cate_id');
            $category = Category::find($cate_id);
            if ($category->parent_id == null) {
                // Lấy tất cả các danh mục con của danh mục gốc
                $subCategoryIds = Category::where('parent_id', $cate_id)->pluck('id')->toArray();
                $subCategoryIds[] = $cate_id;
                $query->whereIn('cate_id', $subCategoryIds);
            } else {
                $query->where('cate_id', $cate_id);
            }
        }
        //Lấy theo cửa hàng
        if ($request->has('store_id') && $data['store_id'] != null) {
            $query->where('store_id', '=', $data['store_id']);
        }
        //Lấy theo từ khóa
        if ($request->has('search') && $data['search'] != null) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
        $products = $query->get();
        $store = Store::find($data['store_id']);
        $categories  =1;
        if($store){
            $allProductByStore = $store->products;
            $categoryIds = $allProductByStore->pluck('cate_id')->unique();
            $categories = Category::whereIn('id', $categoryIds)->get();
        }
        // Lấy danh mục theo các sản phẩm đã lấy được


        $nameCate = Category::find($request->input('cate_id'))->name??"";
        $keyword = $request->input('search')??"";
        return view('client.page.search', [
            'products' => $products,
            'categories' => $categories,
            'nameCate' => $nameCate,
            'keyword' => $keyword,
            'store' => $store,
            'count' => $products->count(),
        ]);
    }
    public function profile(Request $request){
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $user = Auth::user();
        $shipping = $user->shippings;
        $orders = $user->orders()->orderBy('id', 'desc')->get();

        // dd($orders);
        return view('client.page.profile',[
            'user'=> $user,
            'shippings'=> $shipping,
            'orders'=> $orders,
        ]);
    }
    public function productDetail(string $id){

        $product = Product::find($id);
        $store = Store::find($product->store_id);
        $viewcount = Product::find($id) -> increment('view_count');
        $relatedProduct = $product::whereHas('category', function ($query) use ($product) {
            $query->where('parent_id', '=', $product->category->parent_id);
        })
        ->where('id', '!=', $product->id)
        ->take(4)
        ->get();
        // dd($relatedProduct);
        return view('client.page.detail',[
            'product'=> $product,
            'store'=> $store,
            'relatedProduct'=> $relatedProduct,
        ]);
    }

    public function cart(){
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->get();
        // Lấy danh sách các sản phẩm trong giỏ hàng của người dùng
        $productIds = Cart::where('user_id', $user->id)->pluck('product_id');

        // Lấy danh sách các cửa hàng có sản phẩm trong giỏ hàng
        $stores = Store::whereHas('products', function ($query) use ($productIds) {
            $query->whereIn('id', $productIds);
        })->get();

        // $groupedCarts = $carts->groupBy(function ($cart) {
        //     return $cart->product->store_id; // Giả sử product có trường store_id đại diện cho cửa hàng
        // });
        // dd($stores);

        // dd($carts);
        return view('client.page.cart',[
            'stores'=> $stores,
            'carts'=> $carts,
        ]);
    }
    public function payment(){
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $carts = Cart::where('user_id', Auth::user()->id)
            ->where('status', 1)
            ->get();
        $user = Auth::user();
        $shipping = Shipping::where('user_id', $user->id)
            ->where('default', 1)->first();
        return view('client.page.payment',[
            'carts'=> $carts,
            'user'=> $user,
            'shipping'=> $shipping,
        ]);
    }
    public function thankyou(){
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)->latest()->first();
        // dd($order);
        return view('client.page.thankyou',[
        ]);
    }
}
