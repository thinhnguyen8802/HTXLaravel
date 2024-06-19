<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Store;
use App\Models\Category;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }


    public function formatMoney($price) {
        return number_format($price, 0, '', ',') ." đ";
    }
    public function convertMoney( $n, $precision = 1 ) {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 10000000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        }
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }
        return $n_format . $suffix;
    }
}
