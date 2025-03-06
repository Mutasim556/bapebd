<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('UserStatusCheckMid')->only('login');
    }
    public function login(){
        $type = request()->type;
        session()->put('prev_url',url()->previous());
        return view('frontend.blade.auth.login',compact('type'));
    }

    public function attemptLogin(Request $data){
        $prev = session()->get('prev_url')==$data->page_url?url('/'):session()->get('prev_url');
        $data->validate([
            'email'=>'required',
            'password'=>'required',
        ],[
            'email.required'=>__('admin_local.Email or Phone is Required'),
            'password.required'=>__('admin_local.Password is Required'),
        ]);
        $credential1 = [
            'email'=>$data->email,
            'password'=>$data->password,
        ];
        $credential2 = [
            'phone'=>$data->email,
            'password'=>$data->password,
        ];
        if(Auth::attempt($credential1)){
            return response([
                'login'=>true,
                'redirect_url'=>$prev??url('/'),
            ]);
        }elseif(Auth::attempt($credential2)){
            return response([
                'login'=>true,
                'redirect_url'=>$prev??url('/'),
            ]);
        }else{
            return response([
                'login'=>false,
                'message'=>__('admin_local.Invalid email or password')
            ]);
        }
    }
    public function attemptLogout(){
        Auth::logout();
        return redirect()->back();
    }

    public function register(Request $data){
        $data->validate([
            'name'=>'required',
            'email'=>'required|max:50|email|unique:users,email',
            'phone'=>'required|max:13|unique:users,phone',
            'password'=>'required|min:4',
            'confirm_password'=>'required|same:password',
        ],[
            'name.required'=>__('admin_local.Name is required'),
            'email.required'=>__('admin_local.Email is required'),
            'email.max'=>__('admin_local.Email hould be less then 50 charecter'),
            'email.email'=>__('admin_local.Invalid Email'),
            'email.unique'=>__('admin_local.This email already used'),
            'phone.required'=>__('admin_local.Phone number is required'),
            'phone.max'=>__('admin_local.Phone number should be less then 13 charecter'),
            'phone.unique'=>__('admin_local.This phone number already used'),
            'password.required'=>__('admin_local.Password id required'),
            'password.min'=>__('admin_local.Password length should be more then 4'),
            'confirm_password.required'=>__('admin_local.Confirm password id required'),
            'confirm_password.same'=>__('admin_local.Confirm password doesnt match'),
        ]);

        $user = new User();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->phone = $data->phone;
        $user->password = Hash::make($data->password);
        $user->save();
        $credential1 = [
            'email'=>$data->email,
            'password'=>$data->password,
        ];
        if(Auth::attempt($credential1)){
            return response([
                'login'=>true,
                'redirect_url'=>url('/'),
            ]);
        }
    }
}
