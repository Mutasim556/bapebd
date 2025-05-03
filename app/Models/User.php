<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\FrontEnd\PurchaseCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'username',
        'phone',
        'image',
        'status',
        'delete'
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

    public function purchasedCourses($id){
        $data = PurchaseCourse::with('batch')->where('user_id',$id)->get();
        $arr = [];
        foreach($data as $value){
            dd($value->batch());
            if($value->course_type=='Live' && $value->batch->batch_end_date<=date('Y-m-d')){

                $arr[]=$value->course_id;
            }
            if($value->course_type=='Pre-recorded'){
                $arr[]=$value->course_id;
            }
        }
        return $arr;
    }
}
