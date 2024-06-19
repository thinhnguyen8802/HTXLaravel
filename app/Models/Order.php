<?php

namespace App\Models;

use App\Models\User;
use App\Models\Store;
use App\Models\Wards;
use App\Models\District;
use App\Models\Province;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    const PENDING_CONFIRMATION = 0;
    const PACKAGING = 1;
    const SHIPPING = 2;
    const DELIVERED = 3;
    const DELIVERY_FAILED = 4;
    const REJECTED = -1;

    // Ánh xạ giá trị với tên trạng thái
    public static $statusLabels = [
        self::PENDING_CONFIRMATION => 'Chờ xác nhận',
        self::PACKAGING => 'Đã xác nhận',
        self::SHIPPING => 'Đang vận chuyển',
        self::DELIVERED => 'Đã giao hàng',
        self::DELIVERY_FAILED => 'Giao hàng thất bại',
        self::REJECTED => 'Hủy đơn',
    ];

    // Ánh xạ giá trị với màu sắc trạng thái
    public static $statusColors = [
        self::PENDING_CONFIRMATION => 'yellow',
        self::PACKAGING => 'orange',
        self::SHIPPING => 'blue',
        self::DELIVERED => 'green',
        self::DELIVERY_FAILED => 'red',
        self::REJECTED => 'red',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderdetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function province(){
        return $this->belongsTo(Province::class, 'provinceId');
    }
    public function district(){
        return $this->belongsTo(District::class, 'districtId');
    }
    public function wards(){
        return $this->belongsTo(Wards::class, 'wardsId');
    }
}
