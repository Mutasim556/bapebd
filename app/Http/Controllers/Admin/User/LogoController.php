<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UploadLogoRequest;

use App\Models\Admin\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class LogoController extends Controller
{
    public function GetLogo(){
        return view('backend.blade.logos.index');
    }

    public function UploadLogo(Request $data){
        // return response([
        //     'message'=>'ERR'
        // ],200);
        if($data->type=='image'){
            $data->validate([
                'image'=>'mimes:png,jpg,jpeg|max:2000|required'
            ]);
            $manager = new ImageManager(new Driver);
            $image = $manager->read($data->image);

            $height = $image->height();
            $width = $image->width();

            if($data->position=='admin_top'){
                // if($height!=60 || $width!=92){
                if($height!=60 || $width!=92){
                    return response()->json(['message'=>__('admin_local.Admin top image must be 92x60')],422);
                }else{
                    $file = $data->image;
                    $extension = $file->getClientOriginalExtension();
                    $file_name = "admin_top-".time().'.'.$extension;

                    $file->move(public_path('bipebd/files/web_images'),$file_name);
                    $create = Logo::create([
                        'logo_for'=>$data->content_for,
                        'logo_position'=>$data->position,
                        'company_name'=> 'Bipebd',
                        'logo_type'=> $data->type,
                        'logo_image' => 'public/bipebd/files/web_images/'.$file_name,
                        'logo_image_dimention'=>$width.'x'.$height,
                        'logo_image_size'=> filesize(public_path('bipebd/files/web_images/'.$file_name)),
                    ]);

                    if($create){
                        return $create;
                    }else{
                        return response()->json(['message'=>'Server error'],422);
                    }

                }
            }elseif($data->position=='admin_bottom'){
                // if($height!=60 || $width!=92){
                if(1!=1){
                    return response()->json(['message'=>__('admin_local.Admin bottom image must be 92x60')],422);
                }else{
                    $file = $data->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $file_name = "admin_bottom-".time().'.'.$extension;

                    $file->move(public_path('bipebd/files/web_images'),$file_name);
                    $create = Logo::create([
                        'logo_for'=>$data->content_for,
                        'logo_position'=>$data->position,
                        'company_name'=> 'Bipebd',
                        'logo_type'=> $data->type,
                        'logo_image' => 'public/bipebd/files/web_images/'.$file_name,
                        'logo_image_dimention'=>$width.'x'.$height,
                        'logo_image_size'=> filesize(public_path('bipebd/files/web_images/'.$file_name)),
                    ]);

                    if($create){
                        return $create;
                    }else{
                        return response()->json(['message'=>__('admin_local.Server error')],422);
                    }

                }
            }elseif($data->position=='bipebd_top'){
                // if($height!=44 || $width!=182){
                if(1!=1){
                    return response()->json(['message'=>__('admin_local.Bipebd it top logo must be 182x44')],422);
                }else{
                    $file = $data->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $file_name = "bipebd_top-".time().'.'.$extension;

                    $file->move(public_path('bipebd/files/web_images/bipebd'),$file_name);
                    $create = Logo::create([
                        'logo_for'=>$data->content_for,
                        'logo_position'=>$data->position,
                        'company_name'=> 'Bipebd',
                        'logo_type'=> $data->type,
                        'logo_image' => 'public/bipebd/files/web_images/bipebd/'.$file_name,
                        'logo_image_dimention'=>$width.'x'.$height,
                        'logo_image_size'=> filesize(public_path('bipebd/files/web_images/bipebd/'.$file_name)),
                    ]);

                    if($create){
                        return $create;
                    }else{
                        return response()->json(['message'=>__('admin_local.Server error')],422);
                    }

                }
            }
            elseif($data->position=='bipebd_bottom'){
                // if($height!=44 || $width!=182){
                if(1!=1){
                    return response()->json(['message'=>__('admin_local.Bipebd it bottom logo must be 182x44')],422);
                }else{
                    $file = $data->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $file_name = "bipebd_bottom-".time().'.'.$extension;

                    $file->move(public_path('bipebd/files/web_images/bipebd'),$file_name);
                    $create = Logo::create([
                        'logo_for'=>$data->content_for,
                        'logo_position'=>$data->position,
                        'company_name'=> 'Bipebd',
                        'logo_type'=> $data->type,
                        'logo_image' => 'public/bipebd/files/web_images/bipebd/'.$file_name,
                        'logo_image_dimention'=>$width.'x'.$height,
                        'logo_image_size'=> filesize(public_path('bipebd/files/web_images/bipebd/'.$file_name)),
                    ]);

                    if($create){
                        return $create;
                    }else{
                        return response()->json(['message'=>__('admin_local.Server error')],422);
                    }

                }
            }
        }elseif($data->type=='text'){
            $data->validate([
                'text'=>'required|max:255',
            ]);

            $create = Logo::create([
                'logo_for'=>$data->content_for,
                'logo_position'=>$data->position,
                'company_name'=> 'Dreams',
                'logo_type'=> $data->type,
                'logo_image' => $data->text,
                'logo_image_dimention'=>NULL,
                'logo_image_size'=> NULL,
            ]);

            if($create){
                return $create;
            }else{
                return response()->json(['message'=>__('admin_local.Server error')],422);
            }
        }
    }

    public function SearchLogo(Request $data){
        $logoes = DB::table('logos')->where('logo_delete',0);
        if($data->content_for_serach){
            $logoes =$logoes->where('logo_for',$data->content_for_serach);
        }
        if($data->position_serach){
            $logoes =$logoes->where('logo_position',$data->position_serach);
        }
        if($data->type_serach){
            $logoes =$logoes->where('logo_type',$data->type_serach);
        }

        if(!$data->content_for_serach && !$data->position_serach && !$data->type_serach){
            return response()->json(['message'=>__('admin_local.Blank search . Please select one for search')],422);
        }
        $logoes = $logoes->get();


        if($logoes->count()>0){
            return $logoes;
        }else{
            return response()->json([
                'message'=>__('admin_local.No result found'),
            ],422);
        }

    }

    public function LogoStatusChange(){
        $logo = Logo::where('logo_id',request()->id)->first();

        if($logo->logo_status=='Active'){
            $check_logo = Logo::where('logo_for',$logo->logo_for)->where('logo_position',$logo->logo_position)->where('logo_status','Active')->count();
            // return $check_logo;
            if($check_logo>1){
                Logo::where('logo_id',request()->id)->update([
                    'logo_status'=>'Inactive',
                ]);
                return $check_logo;
            }else{
                return response()->json([
                    'message'=>__('admin_local.You cant change status . Because all logo is inactive')
                ],422);
            }

        }else{
            Logo::where('logo_for',$logo->logo_for)->where('logo_position',$logo->logo_position)->where('logo_status','Active')->update([
                'logo_status'=>'Inactive',
            ]);
            Logo::where('logo_id',request()->id)->update([
                'logo_status'=>'Active',
            ]);
            return 1;
        }
    }

    public function DeleteLogo(){
        $logo = Logo::where('logo_id',request()->id)->first();
        if($logo->logo_status=='Active'){
            return response()->json([
                'message'=>'Sorry ! you cant delete active logo . '
            ],422);
        }else{
            Logo::where('logo_id',request()->id)->update([
                'logo_delete'=>1,
            ]);
            return 1;
        }
    }
}
