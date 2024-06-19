<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Store;
use App\Models\Wards;
use App\Models\District;
use App\Models\Province;
use App\Models\Question;
use App\Models\Shipping;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function store()
    {
        return $this->hasOne(Store::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
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
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function shippings()
    {
        return $this->hasMany(Shipping::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
