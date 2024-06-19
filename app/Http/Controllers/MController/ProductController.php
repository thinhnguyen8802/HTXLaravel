<?php

namespace App\Http\Controllers\MController;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('store_id', Auth::user()->store->id)->get();
        return view("manager.page.products.index",[
            'data'=>$products,
        ]);
    }

    public function create()
    {
        $categories = Category::where('parent_id', '!=', null)->get();
        return view("manager.page.products.create",[
            "cates"=> $categories,
        ]);
    }

    public function store(ProductRequest $request)
    {
        $product = new Product;
        $data = $request->all();
        $product->store_id = $data["store_id"];
        $product->cate_id = $data["cate_id"];
        $product->name = $data["name"];
        $product ->slug = Str::slug($data["name"]);
        $product->code = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', trim($data["code"])));
        $product->short_desc = $data["short_desc"];
        $product->price_origin = $data["price_origin"];
        $product->price_sale = $data["price_sale"];
        $product->pcs = $data["pcs"];
        $request->status == "on" ? $product->status = 1 :  $product->status = 0 ;
        $product->description = $data["description"];
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('products', $request->file('image'), $name);
            $product->thumbnail = $path;
        };
        $save = $product->save();
        if($save){
            $request->session()->flash('success', 'Thêm mới thành công');
            return redirect()->route('products.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }
    }

    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Category::where('parent_id', '!=', null)->get();
        return view("manager.page.products.edit",[
            'data'=>$product,
            'cates'=>$categories,
        ]);
    }

    public function update(ProductRequest $request, string $id)
    {
        $product = Product::find($id);
        $data = $request->all();
        $product->name = $data["name"];
        $product->cate_id = $data["cate_id"];
        $product ->slug = Str::slug($data["name"]);
        $product->code = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', trim($data["code"])));
        $product->short_desc = $data["short_desc"];
        $product->price_origin = $data["price_origin"];
        $product->price_sale = $data["price_sale"];
        $product->pcs = $data["pcs"];
        $request->status == "on" ? $product->status = 1 :  $product->status = 0 ;
        $product->description = $data["description"];
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('products', $request->file('image'), $name);
            $product->thumbnail = $path;
        };
        $save = $product->save();
        if($save){
            $request->session()->flash('success', 'Cập nhật thành công');
            return redirect()->route('products.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
