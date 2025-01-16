<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Admin as Instructor;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:instructor-index,admin'])->only('index');
        $this->middleware(['permission:instructor-create,admin'])->only('store');
        $this->middleware(['permission:instructor-update,admin'])->only(['edit','update','updateStatus']);
        $this->middleware(['permission:instructor-delete,admin'])->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $instructors = Instructor::where([['delete','0']])->get();
        $roles = Role::all();
        $instructors = $instructors->reject(function ($instructor, $key) {
            return $instructor->getRoleNames()->first()!='Instructor';
        });
        $roles = $roles->reject(function ($role, $key) {
            return $role->name!='Instructor';
        });
        return view('backend.blade.instructor.index',compact('instructors','roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $data) : Response
    {
        $instructor = new Instructor();
        $instructor->name = $data->instructor_name;
        $instructor->email = $data->instructor_email;
        $instructor->phone = $data->instructor_phone;
        $instructor->username = $data->instructorname;
        $instructor->password = Hash::make($data->instructor_password);
        $instructor->save();
        $instructor->assignRole('Instructor');

        // Mail::to($data->user_email)->send(new CreateUserMail($data->user_email,$data->user_password));

        if($instructor){
            $instructor = Instructor::where('id',$instructor->id)->first();
            return response([
                'instructor'=>$instructor,
                'role' => $instructor->getRoleNames()->first(),
                'title'=>__('admin_local.Congratulations !'),
                'text'=>__('admin_local.Instructor created successfully'),
                'confirmButtonText'=>__('admin_local.Ok'),
                'hasAnyPermission' => hasPermission(['instructor-update','instructor-delete']),
                'hasEditPermission' => hasPermission(['instructor-update']),
                'hasDeletePermission' => hasPermission(['instructor-delete']),
            ]);
        }else{
            return response()->json([
                'message'=>__('admin_local.Something went wrong.'),
                'title'=>__('admin_local.Warning !'),
                'confirmButtonText'=>__('admin_local.Ok'),
            ],422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) : Response
    {
        $instructor = Instructor::findOrFail($id);
        $role = $instructor->getRoleNames()->first();

        return response([
            'instructor'=>$instructor,
            'role'=>$role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $data, string $id) :Response
    {
        $data->validate([
            'user_name'=>'required|max:50',
            'username'=>'required|max:50|unique:users,username,'.$id,
            'user_email'=>'required|email|max:40|unique:users,email,'.$id,
            'user_phone'=>'required|min:11|max:15|unique:users,phone,'.$id,
        ]);
        if($data->user_password){
            $data->validate([
                'user_password'=>'max:30|min:4'
            ]);
            $update = Instructor::where('id',$id)->update([
                'name' => $data->user_name,
                'email' => $data->user_email,
                'phone' => $data->user_phone,
                'username' => $data->username,
                'password' => Hash::make($data->user_password),
            ]);
            $user = Instructor::findOrFail($id);
            $user->syncRoles($data->user_role);
        }else{
            $update = Instructor::where('id',$id)->update([
                'name' => $data->user_name,
                'email' => $data->user_email,
                'phone' => $data->user_phone,
                'username' => $data->username,
            ]);
            $user = Instructor::findOrFail($id);
            $user->syncRoles($data->user_role); 
        }

        if($update){
            $role = $user->getRoleNames()->first();
            return response([
                'user'=>$user,
                'role'=>$role,
                'role' => $user->getRoleNames()->first(),
                'title'=>__('admin_local.Congratulations !'),
                'text'=>__('admin_local.User updated successfully'),
                'confirmButtonText'=>__('admin_local.Ok'),
            ]);
        }else{
            return response()->json([
                'message'=>__('admin_local.Something went wrong.'),
            ],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id):Response
    {
        Instructor::where('id',$id)->update(['delete'=>1,'status'=>0,'updated_at'=>Carbon::now()]);
        return response([
            'message'=>'Deleted',
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.User removed successfully'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

     
    public function updateStatus(string $id,string $status) 
    {
       
        try {
            $user = Instructor::findOrfail($id);
            $user->status = $status;
            $user->updated_at = Carbon::now();
            $user->save();
            return $user;
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => __('admin_local.Someting went wrong!')]);
        }
    }
}
