<?php

namespace App\Http\Controllers\BEController;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Question::get();
        return view("backend.page.questions.index",[
            'data'=>$data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("backend.page.questions.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $q = new Question;
        $data = $request->all();
        $q->user_id = 1;
        $q->title = $data["title"];
        $q->description = $data["description"];
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('blogs', $request->file('image'), $name);
            $q->image = $path;
        };
        $save = $q->save();
        if($save){
            $request->session()->flash('success', 'Thêm mới thành công');
            return redirect()->route('questions.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $q = Question::find($id);
        return view("backend.page.questions.edit",[
            'data'=>$q,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,string $id)
    {
        $q = Question::find($id);
        $data = $request->all();
        $q->user_id = 1;
        $q->title = $data["title"];
        $q->description = $data["description"];
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('blogs', $request->file('image'), $name);
            $q->image = $path;
        };
        $save = $q->save();
        if($save){
            $request->session()->flash('success', 'Cập nhật thành công');
            return redirect()->route('questions.index');
        }
        else{
            $request->session()->flash('faild', 'Đã xảy ra lỗi! Vui lòng kiểm tra lại');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {

    }
}
