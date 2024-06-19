<?php

namespace App\Http\Controllers\BEController;

use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::get();
        return view('backend.page.stores.index', [
            'data'=> $stores,
        ]);
    }


    public function create()
    {
        return view('backend.page.stores.create');
    }

    public function store(StoreRequest $request)
    {
        $store = new Store();
        $data = $request->all();
        $store->name = $data['name'];
        $store->description = $data['description'];
        $store->address = $data['address'];
        $store->phone = $data['phone'];
        $store->tax_code = $data['tax_code'];

        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('store/logo', $request->file('image'), $name);
            $store->logo = $path;
        };
        $save = $store->save();
        if($save){
            $request->session()->flash('success', 'Thêm mới thành công');
            return redirect()->route('stores.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }
    }

    public function edit(string $id)
    {
        $store = Store::find($id);
        return view("backend.page.stores.edit",[
            'data'=> $store,
        ]);
    }

    public function update(StoreRequest $request, string $id)
    {
        $store = Store::find($id);
        $data = $request->all();
        $request->status == "on" ? $store->status = 1 :  $store->status = 0 ;
        $store->name = $data['name'];
        $store->description = $data['description'];
        $store->address = $data['address'];
        $store->phone = $data['phone'];
        $store->tax_code = $data['tax_code'];

        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('store/logo', $request->file('image'), $name);
            $store->logo = $path;
        };
        $save = $store->save();
        if($save){
            $request->session()->flash('success', 'Cập nhật thành công');
            return redirect()->route('stores.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }

    }


    public function destroy(string $id)
    {
    }
}
