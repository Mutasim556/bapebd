<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FrontEnd\CustomerMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OtherPageController extends Controller
{
    public function __construct(){
        $this->middleware('permission:user-message-index,admin')->only(['getUserMessages','getMessagesData']);
        $this->middleware('permission:user-message-reply,admin')->only('saveReplyMessage');
        $this->middleware('permission:user-message-delete,admin')->only('deleteMessage');
    }

    public function aboutUs(){
        return view('frontend.blade.about.index');
    }

    public function contactUs(){
        return view('frontend.blade.contact.index');
    }

    public function sendMessages(Request $data){
        $data->validate([
            'name'=>'required|max:30',
            'email'=>'required|max:40|email',
            'subject'=>'required',
            'phone'=>'required|numeric|max_digits:14|min_digits:11',
            'message'=>['required',function ($attribute, $value, $fail) {
                                        if ($value !== strip_tags($value)) {
                                            $fail(__('admin_local.Mesaage can not contain script'));
                                        }elseif (str_word_count(strip_tags($value)) > 50) {
                                            $fail(__('admin_local.Massage sholud be maximum 50 word'));
                                        }
                                    },]
        ],[
            'name.required'=>__('admin_local.Name is required'),
            'name.max'=>__('admin_local.Name length should be less then 31'),
            'email.required'=>__('admin_local.Email is required'),
            'email.max'=>__('admin_local.Email length should be less then 41'),
            'email.email'=>__('admin_local.Invalid email format'),
            'subject.required'=>__('admin_local.Subject is required'),
            'phone.required'=>__('admin_local.Phone number is required'),
            'phone.numeric'=>__('admin_local.Invalid phone number'),
            'phone.max_digits'=>__('admin_local.Phone shold be less then 15 digits'),
            'phone.min_digits'=>__('admin_local.Phone shold be greater then 10 digits'),
            'message.required'=>__('admin_local.Message is required'),
        ]);

        $message = new CustomerMessage();
        $message->name = $data->name;
        $message->email = $data->email;
        $message->phone = $data->phone;
        $message->subject = $data->subject;
        $message->message = $data->message;
        $message->save();

        return back()->with('success_message',__('admin_local.We have received your messages.We will reply you as soon as possible'));
    }

    public function allInstructor(){
        return view('frontend.blade.instructor.index');
    }

    public function getUserMessages(){
        if(isset(request()->start_date) && isset(request()->end_date)){
            $start_date = date('Y-m-d',strtotime(request()->start_date));
            $end_date = date('Y-m-d',strtotime(request()->end_date));
        }else{
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }
        $messages = CustomerMessage::with('subjectDetails','repliedBy')->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->latest()->take(50)->get();
        // dd($messages);
        return view('backend.blade.others.messages',compact('messages'));
    }

    public function getMessagesData($id){
        if(request()->ajax()){
            $message = CustomerMessage::select('id','reply_status','message','reply_type','reply_subject','reply_message')->findOrFail($id);
            return $message;
        }
    }

    public function saveReplyMessage(Request $data,string $id){
        if($data->reply_type=='Email'){
            $message =  CustomerMessage::findOrFail($id);
            $mailData = ['name' => $message->name, 'reply_message' => $data->reply_message,'bipedbemail'=>config('mail')['default_mail']['mail1'],'institute'=>config('info')['institute_name'],'institute_website'=>config('info')['institute_website']];

            $response = Mail::send('backend.blade.mail.messageMail', $mailData, function ($mail) use($message,$data) {
                $mail->to($message->email)
                    ->from(config('mail')['default_mail']['mail1'], config('info')['institute_name'])
                    ->subject($data->mail_subject);
            });
            if($response){
                $message->reply_status =1;
                $message->reply_type =$data->reply_type;
                $message->reply_subject =$data->mail_subject;
                $message->reply_message =$data->reply_message;
                $message->reply_date = Carbon::now();
                $message->replied_by =Auth::guard('admin')->user()->id;
                $message->save();
                $message =  CustomerMessage::with('repliedBy')->findOrFail($id);
                $message->reply_status=__('admin_local.Replied');
                return response([
                    'message'=>$message,
                    'title'=>__('admin_local.Congratulations !'),
                    'text'=>__('admin_local.Replied successfully.'),
                    'confirmButtonText'=>__('admin_local.Ok'),
                ]);
            }


        }
    }
    public function deleteMessage(string $id){
        $message =  CustomerMessage::findOrFail($id);
        $message->delete();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Message deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }
}
