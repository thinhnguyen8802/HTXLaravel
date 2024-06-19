<?php

namespace App\Models;

use App\Models\Store;
use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;
    public function districts(){
        return $this->hasMany(District::class, 'province_id');
    }

    public function htxs(){
        return $this->hasMany(Store::class, 'provinceId');
    }
}
