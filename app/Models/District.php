<?php

namespace App\Models;

use App\Models\Wards;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;
    public function wards(){
        return $this->hasMany(Wards::class, 'district_id');
    }
    public function province(){
        return $this->belongsTo(Province::class, 'province_id');
    }
}
