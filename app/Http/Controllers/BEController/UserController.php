<?php

namespace App\Http\Controllers\BEController;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return view('backend.page.users.index', [
            'data'=> $users,
        ]);
    }

    public function create()
    {
        return view('backend.page.users.create');

    }

    public function store(UserRequest $request)
    {
        $user = new User();
        $data = $request->all();
        $user->username = $data['username'];
        $user->role_id = $data['role_id'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->phone = $data['phone'];
        $user->name = $data['name'];
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('user', $request->file('image'), $name);
            $user->image = $path;
        };
        $save = $user->save();
        if($save){
            $request->session()->flash('success', 'Lưu thông tin người dùng thành công');
            return redirect()->route('users.index');
        }
        else{
            $request->session()->flash('faild', 'Lưu thông tin người dùng thất bại');
        }
    }


    public function edit(string $id)
    {
        $user = User::find($id);
        return view('backend.page.users.edit', [
            'data'=> $user,
        ]);

    }

    public function update(UserRequest $request, string $id)
    {
        $user = User::find($id);
        $data = $request->all();
        $user->role_id = $data['role_id'];
        $user->phone = $data['phone'];
        $user->name = $data['name'];
        $user->address = $data['address'];
        if($request->hasFile('image')){
            $name = $request->file('image')->getClientOriginalName();
            $path = Storage::disk('public')->putFileAs('user', $request->file('image'), $name);
            $user->image = $path;
        };
        $save = $user->save();
        return redirect()->route('users.index');
    }


    public function destroy( Request $request,string $id)
    {
        $user = User::find($id);
        $delete= $user->delete();
        if($delete){
            $request->session()->flash('success', 'Đã xóa người dùng thành công');
            return redirect()->route('users.index');
        }
    }
}
