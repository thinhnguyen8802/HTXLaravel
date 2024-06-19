<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'cate_id');
    }
}
