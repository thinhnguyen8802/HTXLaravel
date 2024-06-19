<?php

namespace App\Http\Controllers\FEController;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Wards;
use App\Models\District;
use App\Models\Province;
use App\Models\Shipping;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function getRevenue(Request $request){
        $user = Auth::user();
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        if($user->role_id == -1){
            $totalRevenue = Order::where('status', '>=', 1)
                    ->where('status', '<=', 3)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('total');
            return response()->json([
                'error' => 0,
                'total' => $totalRevenue ,
            ]);
        }
        else{
            $store = $user->store;
            if($store == null){
                return response()->json(['error' => 'You are not a store owner'], 200);
            }
            else{
                // Tính tổng doanh thu
                $totalRevenue = Order::where('store_id', $store->id)
                    ->where('status', '>=', 1)
                    ->where('status', '<=', 3)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('total');
                return response()->json([
                    'error' => 0,
                    'total' => $totalRevenue ,
                ]);
            }
        }
    }

    //Xử lý đặt hàng
    public function order(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        // Bắt đầu transaction
        DB::beginTransaction();
        try {
            // Lấy danh sách giỏ hàng có trạng thái là 1 của người dùng
            $carts = Cart::where('user_id', $user->id)
                ->where('status', 1)
                ->get();

            // Tạo một mảng để nhóm các sản phẩm theo store_id
            $groupedCarts = [];
            foreach ($carts as $cart) {
                $storeId = $cart->product->store_id;
                if (!isset($groupedCarts[$storeId])) {
                    $groupedCarts[$storeId] = [];
                }
                $groupedCarts[$storeId][] = $cart;
            }

            // Tạo đơn hàng cho từng nhóm sản phẩm
            $orderIds = [];
            $totalMoney = 0;
            foreach ($groupedCarts as $storeId => $carts) {
                $total = 0;
                foreach ($carts as $item) {
                    $total += $item->product->price_sale * $item->quantity;
                }
                $totalMoney += $total;

                // Tạo mới đơn hàng
                $order = new Order();
                $order->user_id = $user->id;
                $order->total = $total;
                $order->status = 0;
                $order->payment = $data['payment'];
                $order->name = $data['name'];
                $order->phone = $data['phone'];
                $order->provinceId = $data['provinceId'];
                $order->districtId = $data['districtId'];
                $order->wardsId = $data['wardsId'];
                $order->address = $data['address'];
                $order->store_id = $storeId; // Lưu store_id cho đơn hàng
                $order->save();

                $orderIds[] = $order->id;

                // Tạo các orderdetail cho đơn hàng
                foreach ($carts as $item) {
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $item->product_id;
                    $orderDetail->quantity = $item->quantity;
                    $orderDetail->price = $item->product->price_sale;
                    $orderDetail->save();
                    // Xóa sản phẩm trong giỏ hàng
                    $item->delete();
                }
            }
            // Commit transaction sau khi tất cả các thao tác thành công
            DB::commit();
            // Thanh toán VNPay
            if ($data['payment'] == 'vnpay') {
                $vnpUrl = $this->createVNPayUrl($orderIds, $totalMoney);
                return redirect($vnpUrl);
            }

            return redirect()->route('thankyou');
        } catch (\Exception $e) {
            // Nếu có lỗi xảy ra, hủy bỏ giao dịch
            DB::rollBack();
            $request->session()->flash('faild', 'Đã xảy ra lỗi! vui lòng thử lại');
        }
    }

    protected function createVNPayUrl($orderIds, $total)
    {
        $vnp_TmnCode = "QR4JEJ9K"; // Mã website của bạn tại VNPAY
        $vnp_HashSecret = "J93AENMN5W9WH97OCGI71P6Z48ZWN413"; // Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return'); // URL trả về sau khi thanh toán
        $vnp_TxnRef = implode(',', $orderIds); // Mã đơn hàng, gộp nhiều đơn hàng lại
        $vnp_OrderInfo = "Thanh toán đơn hàng";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $total * 100; // Số tiền thanh toán (theo VNPay, số tiền phải nhân 100)
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB"; // Nếu không muốn chọn ngân hàng mặc định
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return $vnp_Url;
    }
    public function vnpayReturn(Request $request)
    {
        $vnp_SecureHash = $request->vnp_SecureHash;
        $vnp_TxnRef = $request->vnp_TxnRef; // Danh sách các orderId, được nối bằng dấu phẩy
        $vnp_ResponseCode = $request->vnp_ResponseCode;

        $orderIds = explode(',', $vnp_TxnRef);

        if ($vnp_ResponseCode == '00') {
            // Thanh toán thành công
            foreach ($orderIds as $orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    $order->status = 1; // Hoặc trạng thái tương ứng của bạn
                    $order->save();
                }
            }

            return redirect('/thankyou');
        } else {
            // Thanh toán không thành công
            foreach ($orderIds as $orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    $order->status = -1; // Hoặc trạng thái thất bại
                    $order->save();
                }
            }

            return redirect('/payment-failure');
        }
    }


    public function cancelOrder(){
        $orderId = request()->input('id');
        $order = Order::find($orderId);
        if($order){
            $order->status = -1;
            $order->save();
            return response()->json(['error'=>0, 'msg'=>'Đã hủy đơn hàng!']);
        }
    }
    public function viewOrder(Request $request){
        $id = $request->input('id'); // Lấy id từ yêu cầu Ajax
        $order = Order::with(['orderDetails.product', 'province', 'district', 'wards'])
                    ->where('id', $id)
                    ->first();
        if($order){
            // Thay đổi trạng thái từ giá trị số sang văn bản tương ứng
            $order->status_text = Order::$statusLabels[$order->status] ?? 'Unknown';

            // Trả về dữ liệu đơn hàng dưới dạng JSON nếu tìm thấy
            return response()->json([
                'error' => 0,
                'data' => $order
            ]);
        } else {
            // Trả về thông báo lỗi nếu không tìm thấy đơn hàng
            return response()->json([
                'error' => 1,
                'msg' => 'Không tìm thấy đơn hàng!'
            ]);
        }
    }



    public function getListOrder(Request $request)
    {
        // Lấy thông tin từ yêu cầu AJAX của DataTables
        $draw = $request->input('draw');
        $orderColumnIndex = $request->input('order')[0]['column']; // Lấy chỉ số cột để sắp xếp
        $orderDir = $request->input('order')[0]['dir']; // Lấy hướng sắp xếp (asc/desc)
        $start = $request->input('start'); // Vị trí bắt đầu lấy dữ liệu
        $length = $request->input('length'); // Số lượng bản ghi cần lấy

        // Định nghĩa các cột có thể sắp xếp
        $columns = ['orders.id', 'orders.total','orders.phone', 'orders.address', 'orders.created_at', 'orders.status', 'orders.id'];

        // Kiểm tra xem chỉ số cột có hợp lệ không
        if (!isset($columns[$orderColumnIndex])) {
            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => []
            ]);
        }

        $orderColumn = $columns[$orderColumnIndex]; // Lấy tên cột cần sắp xếp

        // Query dữ liệu từ database với join và phân trang, sắp xếp
        $query = Order::with(['orderDetails.product', 'province', 'district', 'wards'])
            ->where('user_id', Auth::user()->id)
            ->select([
                'orders.total',
                'orders.phone',
                'orders.address',
                'orders.created_at',
                'orders.status',
                'orders.id',
                'orders.provinceId',
                'orders.districtId',
                'orders.wardsId'
            ]);

        // Tính tổng số lượng bản ghi (recordsTotal)
        $total = $query->count();

        // Áp dụng sắp xếp
        $query->orderBy($orderColumn, $orderDir);

        // Áp dụng phân trang
        $orders = $query->skip($start)->take($length)->get();

        // Định dạng lại dữ liệu sau khi lấy ra
        $orders = $orders->map(function ($order) {
            $order->status = Order::$statusLabels[$order->status] ?? 'Unknown';
            $order->address = $order->address . ', ' . optional($order->wards)->name . ', ' . optional($order->district)->name . ', ' . optional($order->province)->name;
            return [
                'products' => $order->orderDetails->map(function ($detail) {
                    return $detail->product;
                }),
                'phone' => $order->phone,
                'total' => $order->total,
                'address' => $order->address,
                'created_at' => $order->created_at,
                'status' => $order->status,
                'id' => $order->id,
            ];
        });

        // Chuẩn bị dữ liệu để trả về cho DataTables
        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $total, // Tổng số bản ghi trong bảng
            'recordsFiltered' => $total, // Số lượng bản ghi sau khi lọc (nếu có)
            'data' => $orders // Dữ liệu để hiển thị trong DataTables
        ]);
    }

    public function getShippings(Request $request)
    {
        // $userId = Auth::user()->id;


        $data = Shipping::where('user_id', Auth::user()->id)
        ->select([
            'shippings.id',
            'shippings.name',
            'shippings.phone',
            'shippings.address',
            'shippings.created_at',
            'shippings.default',
            'provinces.name as province_name',
            'districts.name as district_name',
            'wards.name as ward_name'
        ])

        ->leftJoin('provinces', 'shippings.provinceId', '=', 'provinces.id')
        ->leftJoin('districts', 'shippings.districtId', '=', 'districts.id')
        ->leftJoin('wards', 'shippings.wardsId', '=', 'wards.id')
        ->orderBy("id", "desc")->get();
        foreach ($data as $item) {
            $item->address = $item->address . ', ' . $item->ward_name . ', ' . $item->district_name . ', ' . $item->province_name;
            if ($item->default == 1) {
                $item->address .= ' (mặc định)';
            }
        }
        return response()->json([
            'data' => $data
        ]);
    }

    public function getDataShipping(Request $request, $id){
        $shipping = Shipping::where('id', $id)->first();
        return response()->json([
            'error' => 0,
            'data' =>$shipping
        ]);
    }

    public function updateShipping(Request $request){
        $data = $request->all();
        // Đặt tất cả các bản ghi khác của người dùng này thành default = 0
        if ($data['default'] == 1) {
            Shipping::where('user_id', $data['user_id'])
                ->where('id', '!=', $data['id'])
                ->update(['default' => 0]);
        }
        $sp = Shipping::updateOrCreate(
            ['id' => $data['id'] ?? null],
            [
                'user_id' => $data['user_id'],
                'default' => $data['default'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'provinceId' => $data['provinceId'],
                'districtId' => $data['districtId'],
                'wardsId' => $data['wardsId'],
                'address' => $data['address']
            ]
        );
        return response()->json([
            'error' => 0,
            'msg' => $sp->wasRecentlyCreated ? 'Địa chỉ giao hàng đã được tạo mới.' : 'Địa chỉ giao hàng đã được cập nhật.'
        ]);
    }

    public function addToCart(Request $request)
    {
        $data = $request->all();
        $msg = "";
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng của người dùng chưa
        $cart = Cart::where('user_id', $data['user_id'])
                    ->where('product_id', $data['id'])
                    ->first();
        if ($cart == null) {
            // Tạo mới bản ghi trong giỏ hàng nếu sản phẩm chưa tồn tại trong giỏ hàng
            $cart = new Cart();
            $cart->user_id = $data['user_id'];
            $cart->product_id = $data['id'];
            $cart->quantity = $data['quantity'];
            $cart->status = 1;
            $cart->save();
            $msg ='Đã thêm sản phẩm vào giỏ hàng!';
        } else {
            // Cập nhật thông tin về sản phẩm trong giỏ hàng nếu sản phẩm đã tồn tại
            $cart->quantity += $data['quantity'];
            $cart->save();
           $msg = 'Đã cập nhật giỏ hàng!';
        }
        $carts = Cart::where('user_id', $data['user_id'])->get();
        return response()->json([
            'error' => 0,
            'msg' => $msg,
            'count' => $carts->count()
        ]);
    }
    public function buyNow(Request $request){

        if(Auth::check()){
            $user =Auth::user();
            $data = $request->all();
            $cart = Cart::where('user_id', $user->id)
                        ->where('product_id', $data['id'])
                        ->first();
            if ($cart == null) {
                $cart = new Cart();
                $cart->user_id = $user->id;
                $cart->product_id = $data['id'];
                $cart->quantity = $data['quantity'];
                $cart->status = 1;
                $cart->save();
            } else {
                $cart->quantity += $data['quantity'];
                $cart->save();
            }
            return redirect()->route('home.cart');
        }
        else{
            return redirect()->route('login');
        }

    }

    public function updateCart(Request $request)
    {
        $data = $request->all();
        $cart = Cart::where('user_id', $data['user_id'])
                    ->where('product_id', $data['id'])
                    ->first();
        if ($cart) {
            $msg = "";
            if ($data['quantity'] == 0) {
                $cart->delete();
                $msg = "Đã xóa sản phẩm khỏi giỏ hàng!";
            } else {
                // Cập nhật quantity
                $cart->quantity = $data['quantity'];
                $cart->save();
                $msg = "Đã cập nhật giỏ hàng!";
            }
            $total = 0;
            $totalMoneyProduct = $cart->quantity * $cart->product->price_sale;
            $carts = Cart::where('user_id', $data['user_id'])->get();
            foreach ($carts as $cart) {
                if($cart->status == 1 ){
                    $total += $cart->quantity * $cart->product->price_sale;
                }
            }
            return response()->json([
                'error' => 0,
                'msg' => $msg,
                'total' => $total,
                'moneyProduct' => $totalMoneyProduct,
                'count' => $carts->count()
            ]);
        } else {
            return response()->json(['error' => 1, 'msg' => 'Sản phẩm không tồn tại trong giỏ hàng!']);
        }
    }
    public function changeStatusCart(Request $request){
        $data = request()->all();
        $cart = Cart::find($data['id']);
        $cart->status = $data['status'];
        $cart->save();
        $carts = Cart::where("user_id", Auth::user()->id)
            ->where('status', 1)
            ->get();
        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart->quantity * $cart->product->price_sale;
        }
        return response()->json(['error' => 0, 'msg' => 'Đã cập nhật trạng thái giỏ hàng!', 'total' => $total]);
    }





    public function getProvinces(Request $request)
    {
        $term = $request->term;
        $provinces = Province::where('name', 'like', '%'.$term.'%')->select('id', 'name as text')->get();
        return response()->json(['results' => $provinces]);
    }

    public function getDistrictsByProvince(Request $request, $province_id)
    {
        $term = $request->term;

        $query = District::where('province_id', $province_id);

        if ($term) {
            $query->where('name', 'like', '%' . $term . '%');
        }

        $districts = $query->select('id', 'name as text')->get();

        return response()->json(['results' => $districts]);
    }

    public function getWardsByDistrict(Request $request, $district_id)
    {
        $term = $request->term;

        $query = Wards::where('district_id', $district_id);
        if ($term) {
            $query->where('name', 'like', '%' . $term . '%');
        }

        $wards = $query->select('id', 'name as text')->get();

        return response()->json(['results' => $wards]);
    }

    public function getNameProvince($id)
    {
        $data = Province::find($id);
        return response()->json($data);
    }

    public function getNameDistrict($id)
    {
        $data = District::find($id);
        return response()->json($data);
    }

    public function getNameWards($id)
    {
        $data = Wards::find($id);
        return response()->json($data);
    }

    public function registerStore(Request $request)
    {
        $checkExist = Store::where("user_id", $request->input('user_id'))->first();
        if($checkExist){
            return response()->json(['error' => 1, 'msg' => 'Bạn đã gửi yêu cầu rồi! Vui lòng đợi phản hồi từ quản trị viên']);
        } else {
            $store = new Store();
            $store->name = $request->input('shopName');
            $store->provinceId = $request->input('provinceId');
            $store->districtId = $request->input('districtId');
            $store->wardsId = $request->input('wardsId');
            $store->address = $request->input('shopAddress');
            $store->map = $request->input('map');
            $store->user_id = $request->input('user_id');
            $save = $store->save();
            if($save){
                return response()->json(['error' => 0, 'msg' => 'Đăng ký thành công! Vui lòng đợi phản hồi từ admin']);
            } else {
                return response()->json(['error' => 1, 'msg' => 'Đã xả ra lỗi! Vui lòng thử lại!']);
            }
        }
    }
    public function approveRequest(Request $request){
        $data = $request->all();
        $store = Store::find($data['id']);
        $store->status = $request->input('status');
        $save = $store->save();

        $user = User::find($store->user_id);
        $user->role_id = 0;
        $user->save();
        if($save){
            $request->session()->flash('success', 'Cập nhật thành công');
            return redirect()->route('stores.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }

    }

    public function updateUser(Request $request){
        // Lấy thông tin từ request
        $user = User::find($request->input('user_id'));
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        if ($request->hasFile('image')) {
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('user', $request->file('image'), $name);
            $user->image = $path;
        }
        $save = $user->save();
        if($save){
            return response()->json(['error' => 0, 'msg' => 'Cập nhật thông tin thành công!', 'url'=>$user->image]);
        } else {
            return response()->json(['error' => 1, 'msg' => 'Đã xả ra lỗi! Vui lòng thử lại!']);
        }

    }

    public function changePassword(Request $request){
        $user = User::find($request->input('user_id'));
        // Kiểm tra mật khẩu cũ
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['error' => 1,'msg' => 'Mật khẩu hiện tại không chính xác']);
        }
        // Thay đổi mật khẩu
        $user->password = Hash::make($request->input('new_password'));
        $user->save();
        return response()->json(['error' => 0, 'msg' => 'Đổi mật khẩu thành công']);
    }
}
