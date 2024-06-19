<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\Wards;
use App\Models\Product;
use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    protected $table = 'stores'; // Tên bảng

    protected $fillable = [
        'name',
        'description',
        'logo_url'
    ]; // Các trường có thể gán giá trị

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
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
