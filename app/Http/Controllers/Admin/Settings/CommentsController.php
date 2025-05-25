<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Admin\Comment;
use App\Models\Admin\Language;
use App\Models\Admin\Translation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:comments-index,admin');
        $this->middleware('permission:comments-update,admin')->only(['edit','update','updateStatus']);
        $this->middleware('permission:comments-create,admin')->only(['store']);
        $this->middleware('permission:comments-delete,admin')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::where([['delete',0],['status',1]])->get();
        return view('backend.blade.settings.comments.index',compact('comments'));
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
    public function store(Request $data)
    {
        $data->validate([
            'student_name'=>'required',
            'student_department'=>'required',
            'student_rating'=>'required',
            'student_image'=>'required|mimes:png,jpg,jpeg',
            'comment'=>'required',
        ]);

        $newcomment = new Comment();

        $newcomment->student_name = $data->student_name;
        $newcomment->student_department = $data->student_department;
        $newcomment->student_rating = $data->student_rating;
        $newcomment->comment = $data->comment;
        if($data->student_image){
            $files = $data->student_image;
            $file = time().'img1.'.$files->getClientOriginalExtension();
            $file_name = 'bipebd/files/settings/homepage/comments/'.$file;
            $manager = new ImageManager(new Driver);
            $manager->read($data->student_image)->resize(70,70)->save(env('ASSET_DIRECTORY').'/'.'bipebd/files/settings/homepage/comments/'.$file);
        }else{
            $file_name = "";
        }
        $newcomment->student_image = $file_name;

        $newcomment->save();

        $languages =  Language::where([['status', 1], ['delete', 0]])->get();
        foreach ($languages as $lang) {
            $comment = $lang->lang != 'en' ? 'comment_' . $lang->lang : 'comment';
            if ($data->$comment == null) {
                continue;
            } else {
                Translation::updateOrInsert([
                    'translationable_type'  => 'App\Models\Admin\Comment',
                    'translationable_id'    => $newcomment->id,
                    'locale'                => $lang->lang,
                    'key'                   => 'comment',
                ],[
                    'value'                 =>  $data->$comment,
                    'updated_at'            => Carbon::now(),
                ]);
            }
        }

        return response([
            'comment' => Comment::findOrFail($newcomment->id),
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Comment create successfully.'),
            'confirmButtonText' => __('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['comments-update', 'comments-delete']),
            'hasEditPermission' => hasPermission(['comments-update']),
            'hasDeletePermission' => hasPermission(['comments-delete']),
        ], 200);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
