<?php

namespace App\Models;

use App\Models\User;
use App\Models\Wards;
use App\Models\District;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shipping extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'default',
        'user_id',
        'provinceId',
        'districtId',
        'wardsId',
        'address',
        'phone',
        'name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
