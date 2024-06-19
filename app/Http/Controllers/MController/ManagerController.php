<?php

namespace App\Http\Controllers\MController;

use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;
        $orderNew = Order::where('store_id', $store->id)->where('status', 0)->count();
        $products = $store->products()->count();
        $orders = Order::where('store_id', $store->id)->get();
        $totalMoney = 0;


        //Lấy ra top sản phẩm bán chạy
        $topSelling = $store->products() // Lấy danh sách sản phẩm của cửa hàng
            ->whereHas('orderDetails', function ($query) {
                $query->whereHas('order', function ($query) {
                    $query->where('status', '!=', -1);
                });
            })
            ->with(['orderDetails' => function ($query) {
                $query->select(['id', 'product_id', 'quantity', 'price'])
                    ->selectRaw('quantity * price as total_price');
            }])
            ->withCount(['orderDetails' => function ($query) {
                $query->select(DB::raw('SUM(quantity) as total_quantity'));
            }])
            ->get();

        $topSelling->map(function ($product) {
            $product->totalRevenue = $product->orderDetails->sum('total_price');
            return $product;
        });
        $topSelling = $topSelling->sortByDesc('order_details_count')->take(10);

        //Lấy ra top khách hàng thân thiết
        $topCustomers = User::with(['orders' => function ($query) use ($store) {
            $query->select('user_id', DB::raw('SUM(total) as total_order'))
                ->where('store_id', $store->id) // Chỉ lấy đơn hàng từ cửa hàng cụ thể
                ->groupBy('user_id')
                ->orderByDesc('total_order')
                ->take(10);
        }])
            ->withCount(['orders' => function ($query) use ($store) {
                $query->where('store_id', $store->id); // Chỉ tính tổng số đơn hàng từ cửa hàng cụ thể
            }])
            ->get();


        foreach ($topCustomers as $customer) {
            $customer->totalSpent = $customer->orders->sum('total_order');
        }
        $topCustomers = $topCustomers->where('totalSpent', '>', 0)->sortByDesc('totalSpent');
        // dd($topCustomers);

        foreach ($orders as $order) {
            if($order->status != -1){
                $totalMoney += $order->total;
            }
        }
        $uniqueUserIds = [];
        // Lặp qua danh sách các đơn hàng
        foreach ($orders as $order) {
            // Lấy user_id của đơn hàng
            $userId = $order->user_id;
            // Kiểm tra xem user_id đã tồn tại trong mảng chưa
            if (!in_array($userId, $uniqueUserIds)) {
                // Thêm user_id vào mảng nếu chưa tồn tại
                $uniqueUserIds[] = $userId;
            }
        }
        // Đếm số lượng user_id độc nhất
        $totalUniqueUsers = count($uniqueUserIds);
        // dd($totalUniqueUsers->count());

        return view("manager.page.dashboard", [
            'store'=>$store,
            'products'=>$products,
            'orders'=>$orders->count(),
            'totalMoney'=>$totalMoney,
            'totalUniqueUsers'=>$totalUniqueUsers,
            'orderNew'=>$orderNew,
            'topSelling'=>$topSelling,
            'topCustomers'=>$topCustomers,
        ]);
    }

    public function statistical()
    {
        //lấy ra id cửa htx cần thống kê
        $store_id = Auth::user()->store->id;

        //Lấy ra toàn bộ đơn hàng của hợp tác xã
        $allOrder = Order::count();
        $orderSuccess = Order::where('status', '=' ,3)->where('store_id', $store_id)->count();

        //lấy rac các đơn hàng có trạng thái là đang xử lý, đang giao
        $orderPending = Order::whereBetween('status', [1,2])->where('store_id', $store_id)->count();
        // Lấy ra các đơn hàng có trạng thái là hủy
        $orderCancel= Order::where('status','=', -1)->where('store_id', $store_id)->count();

        //Lấy ra các đơn ahàng có trạng thái là đang chờ xử lý
        $orderNew =  Order::where('status',0)->where('store_id', $store_id)->count();
        // GIao hàng thất bại
        $orderFaild =  Order::where('status',4)->where('store_id', $store_id)->count();

        //Đưa vào trong mảng
        $rateOrder = [$orderSuccess,$orderPending,$orderNew,$orderCancel, $orderFaild];

        // ds sản phẩm bán chạy
        // Lấy tên sản phẩm và tổng số lượng đã bán
        $productSales = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select('products.name as product_name', DB::raw('SUM(order_details.quantity) as total_quantity'))
            ->where('store_id', $store_id)
            ->groupBy('products.name')
            ->orderByDesc('total_quantity')
            ->get();
        // Khởi tạo danh sách tên sản phẩm và số lượng đã bán
        $listPName = [];
        $listPCount = [];

        // Lặp qua kết quả và thêm vào danh sách
        foreach ($productSales as $item) {
            $listPName[] = $item->product_name;
            $listPCount[] = $item->total_quantity;
        }

        $products = Product::orderBy('quantity_stock', 'ASC')->get();

        //--------------------

        $MonthCurr = Carbon::now()->format('m-Y');
        $from_date = Carbon::now()->startOfMonth();
        $to_date = Carbon::now()->endOfMonth();
        $listDayIsMonth = [];
        while($from_date <= $to_date)
        {
            array_push($listDayIsMonth, $from_date->format('Y-m-d'));
            $from_date->addDay();
        }
        $list_total_order = [];
        $date1 = Order::all()->where('store_id',Auth::user()->store->id )->where('status', '>', 0)->groupBy(function($item){ return $item->created_at->format('Y-m-d'); });
        foreach($listDayIsMonth as $day){
            $total_money = 0;
            foreach($date1 as $item){
                $i =0;
                if($item[$i]->created_at->format('Y-m-d') == $day){
                    foreach($item as $sub_item){
                        $total_money += $sub_item->total;
                    }
                }
            }
            array_push($list_total_order, $total_money);
        }


        return view('manager.page.statistical',[
            'listPName'=>$listPName,
            'listPCount'=>$listPCount,
            'rateOrder'=>$rateOrder,
            'MonthCurr'=>$MonthCurr,
            'products'=>$products,
            'listDayIsMonth' => $listDayIsMonth,
            'list_total_order' => $list_total_order,
        ]);
    }

    //Biểu đồ doanh thu
    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = Carbon::parse($data['from_date']);
        $to_date = Carbon::parse($data['to_date']);
        $listDayIsMonth = [];
        $list_total_order = [];
        while($from_date <= $to_date)
        {
            array_push($listDayIsMonth, $from_date->format('Y-m-d'));
            $from_date->addDay();
        }
        $date1 = Order::all()->where('status', '>', 0)->groupBy(function($item){ return $item->created_at->format('Y-m-d'); });
        foreach($listDayIsMonth as $day){
            $total_money = 0;
            foreach($date1 as $item){
                $i =0;
                if($item[$i]->created_at->format('Y-m-d') == $day){
                    foreach($item as $sub_item){
                        $total_money += $sub_item->total;
                    }
                }
            }
            array_push($list_total_order, $total_money);
        }
        return response()->json(['listDayIsMonth'=>$listDayIsMonth, 'list_total_order'=>$list_total_order]);
    }



    public function editShop(){
        $user = Auth::user();
        $store = $user->store;
        return view("manager.page.editShop", [
            'data'=>$store,
        ]);
    }
    public function updateShop(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;
        $data = $request->all();
        $store->name = $data['name'];
        $store->address = $data['address'];
        $store->phone = $data['phone'];
        $store->map = $data['map'];
        $store->description = $data['description'];

        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('store/logo', $request->file('image'), $name);
            $store->logo = $path;
        };
        $save = $store->save();
        if($save){
            $request->session()->flash('success', 'Cập nhật thành công');
            return redirect()->route('manager.editShop');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }

    }

    public function orders(){
        $user = Auth::user();
        $store = $user->store;
        $data = Order::where('store_id', $store->id)->orderBy('id', 'desc')->get();
        return view("manager.page.orders.index",[
            'data'=>$data,
        ]);
    }
    public function editOrder(string $id){
        $data = Order::find($id);
        return view("manager.page.orders.edit",[
            'data'=>$data,
        ]);
    }
    public function updateOrder(Request $request, string $id){
        $order = Order::find($id);
        $data = $request->all();
        $order->status = $data['status'];
        $save = $order->save();
        if($save){
            $request->session()->flash('success', 'Cập nhật thành công');
            return redirect()->route('manager.orders');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }
    }
}
