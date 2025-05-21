<?php

namespace App\Http\Controllers\Admin\PurchaseHistory;

use App\Http\Controllers\Controller;
use App\Models\Admin\Course\Course;
use App\Models\Admin\Course\CourseBatch;
use App\Models\FrontEnd\Purchase;
use App\Models\FrontEnd\PurchaseCourse;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseHistoryController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index()
    {
        $users = User::where([['status',1],['delete',0]])->get();
        $courses = Course::where([['course_status',1],['course_delete',0]])->get();
        $purchases = Purchase::where([['delete',0]]);
        if(request()->start_date && request()->start_date){
             $purchases = $purchases->whereDate('created_at','>=',date('Y-m-d',strtotime(request()->start_date)))->whereDate('created_at','<=',date('Y-m-d',strtotime(request()->end_date)));
        }
        if(isset(request()->payment_status)){
            $purchases = $purchases->where([['payment_status',request()->payment_status]]);
        }
         $purchases = $purchases->get();
        return view('backend.blade.purchase_history.index',compact('purchases','users','courses'));
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
        // $purchases = Purchase::whereBetween('created_at',[date('Y-m-d',strtotime($data->start_date)),date('Y-m-d',strtotime($data->end_date))])->where([['payment_status',$data->payment_status],['delete',0]])->get();

        // foreach($purchases as $key=>$purchase){
        //     $purchases[$key]->create_date = date('Y-m-d',strtotime($purchase->created_at));
        // }
        // return response([
        //     'purchases'=>$purchases,
        //     'hasAnyPermission' => hasPermission(['course-category-update', 'course-category-delete']),
        //     'hasEditPermission' => hasPermission(['course-category-update']),
        //     'hasDeletePermission' => hasPermission(['course-category-delete']),
        // ]);
        $check = PurchaseCourse::where([['course_id',$data->course_id],['user_id',$data->user_id]]);
        if($data->course_batch){
             $check = $check->where([['batch_id',$data->course_batch]]);
        }
        $check = $check->get();
        if(count($check)<1){
            $courses = Course::where('id',$data->course_id)->get();
            $course_id = '';
            foreach($courses as $key=>$course){
                $course_id = $course_id.$course->id;
                $course_id = $course_id."|";
            }
            $user = User::where('id',$data->user_id)->first();
            $purchase = new Purchase();
            $purchase->courses = json_encode($course_id);
            $purchase->total_amount = 0;
            $purchase->subtotal = 0;
            $purchase->dicount_amount = $course->course_discount_price;
            $purchase->payment_method = 'gift';
            $purchase->payment_status = 1;
            $purchase->phone = $user->phone;
            $purchase->transaction_id = 'GIFT'.uniqid();
            $purchase->payment_option = 'GIFT';
            $purchase->save();
            $live_count = 0;
            $live_batch = explode(',',$data->live_course_batch?implode(',',$data->live_course_batch):'');
            // dd($live_batch);

            $purchase_course = new PurchaseCourse();
            $purchase_course->purchase_id = $purchase->id;
            $purchase_course->user_id = $data->user_id;
            $purchase_course->course_id = $courses[0]->id;
            $purchase_course->course_type = $courses[0]->course_type;
            if($courses[0]->course_type=='Live'){
                $purchase_course->batch_id = $data->course_batch;
            }else{
                $purchase_course->batch_id = null;
            }

            $purchase_course->status = 1;
            $purchase_course->save();
            
            if($courses[0]->course_type=='Pre-recorded'){

                $course_u = Course::findOrFail($courses[0]->id);
                $course_u->enrolled_count = $course_u->enrolled_count+1;
                $course_u->save();
            }

            return true;
        }else{
            return response([
                'message'=>__('admin_local.This user already have this course')
            ],401);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchases_courses = PurchaseCourse::with('course','batch')->where([['purchase_id',$id]])->get();
        return $purchases_courses;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::where([['course_status',1],['course_delete',0],['id',$id]])->first();
        $batches = null;
        if($course->course_type=='Live'){
            $batches = count(CourseBatch::where([['batch_status',1],['batch_delete',0],['course_id',$course->id]])->whereDate('batch_start_date','>=',date('Y-m-d'))->get())>0?CourseBatch::where([['batch_status',1],['batch_delete',0],['course_id',$course->id]])->whereDate('batch_start_date','>=',date('Y-m-d'))->get():null;
        }
        return [
            'course'=>$course,
            'batches'=>$batches,
        ];
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
        $check = Purchase::where('id',$id)->first();
        if($check->payment_status==0){
            PurchaseCourse::where('purchase_id',$id)->delete();
            Purchase::where('id',$id)->delete();

            return true;
        }else{
            return response([
                'message'=>__('admin_local.You can\'t delete the purchase history as it is paid.')
            ],401);
        }
       
    }

    public function changeStatus(Request $data){
        
        $purchases = Purchase::findOrFail(request()->id);
        $purchases->payment_status=request()->status;
        $purchases->updated_at=Carbon::now();
        $purchases->save();

        $purchaseCourse = PurchaseCourse::where('purchase_id',request()->id)->update([
            'status'=>request()->status,
        ]);
        return response($purchases);
    }
}
