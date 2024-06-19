<?php

namespace App\Models;

use App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wards extends Model
{
    use HasFactory;
    public function district(){
        return $this->belongsTo(District::class, 'district_id');
    }
}
