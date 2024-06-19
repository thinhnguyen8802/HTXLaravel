<?php

namespace App\Http\Controllers\BEController;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::where('parent_id', null)->get();
        return view('backend.page.categories.index', [
            'data'=> $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Category::where('parent_id', null)->get();
        return view('backend.page.categories.create',[
            'cateP'=> $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Category();
        $dt = $request->all();
        $request->status == "on" ? $data->status = 1 :  $data->status = 0 ;
        $data->name = $dt["name"];
        $data->parent_id = $dt["parent_id"];
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('banner', $request->file('image'), $name);
            $data->image = $path;
        };
        $save = $data->save();
        if($save){
            $request->session()->flash('success', 'Thêm mới thành công');
            return redirect()->route('categories.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Category::find($id);
        $cateP = Category::whereNull('parent_id')->where('id', '!=', $id)->get();
        return view("backend.page.categories.edit",[
            'data'=> $data,
            'cateP'=> $cateP,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Category::find($id);
        $dt = $request->all();
        $request->status == "on" ? $data->status = 1 :  $data->status = 0 ;
        $data->name = $dt["name"];
        $data->parent_id = $dt["parent_id"];
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('banner', $request->file('image'), $name);
            $data->image = $path;
        };
        $save = $data->save();
        if($save){
            $request->session()->flash('success', 'Cập nhật thành công');
            return redirect()->route('categories.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
