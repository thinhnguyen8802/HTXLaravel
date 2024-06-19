<?php

namespace App\Http\Controllers\BEController;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Banner::get();
        return view('backend.page.banners.index', [
            'data'=> $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.page.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Banner();
        $dt = $request->all();
        $request->status == "on" ? $data->status = 1 :  $data->status = 0 ;
        $data->name = $dt["name"];
        $data->link = $dt["link"];
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('banner', $request->file('image'), $name);
            $data->image = $path;
        };
        $save = $data->save();
        if($save){
            $request->session()->flash('success', 'Thêm mới thành công');
            return redirect()->route('banners.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Banner::find($id);
        return view("backend.page.banners.edit",[
            'data'=> $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Banner::find($id);
        $dt = $request->all();
        $request->status == "on" ? $data->status = 1 :  $data->status = 0 ;
        $data->name = $dt["name"];
        $data->link = $dt["link"];
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('banner', $request->file('image'), $name);
            $data->image = $path;
        };
        $save = $data->save();
        if($save){
            $request->session()->flash('success', 'Cập nhật thành công');
            return redirect()->route('banners.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        //
    }
}
