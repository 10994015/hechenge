<?php

namespace App\Http\Livewire;

use App\Jobs\SendMailQueueJob;
use App\Models\Course;
use App\Models\Letter;
use App\Models\Minute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Validator;
use Livewire\Component;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CourseDetailComponent extends Component
{
    public $name;
    public $phone;
    public $school;
    public $grade = "高中一年級";
    public $content;
    public $captcha;
    public $loading;
    public $courseName;
    public $slug;
    public $course_id;
    protected $listeners = ['addTime'=>'addTime', 'addVisitorCount'=>'addVisitorCount', 'addCount'=>'addCount'];
    public function mount($slug){
        $this->slug = $slug;
        $this->course_id = Course::where('slug', $slug)->first()->id;
        log::info($this->course_id);
    }
    public function clearVar(){
        $this->name = "";
        $this->phone = "";
        $this->school = "";
        $this->grade = "高中一年級";
        $this->content = "";
        $this->captcha = "";
        $this->loading = "";
        $this->courseName = "";
    }
    public function addTime(){
        DB::beginTransaction();
        try{
            if(Minute::where([['date_at', date('Y-m-d')], ['course_id', $this->course_id]])->orderby('id', 'desc')->count() > 0 ){
                $minute = Minute::where([['date_at', date('Y-m-d')], ['course_id', $this->course_id]])->orderby('id', 'desc')->first();
                
                $minute->timestamps  = false;
                $minute->minutes = (float)$minute->minutes + 0.5;
                $minute->save();
                $minute->timestamps = true;
            }else{
                $minute = new Minute();
                $minute->date_at = date("Y-m-d");
                $minute->course_id = $this->course_id;
                $minute->minutes = 0.5;
                $minute->save();
            }
            DB::commit();
        }catch(\Exception $e){
            log::info($e);
            DB::rollback();
        }
        
    }
    public function addCount(){
        DB::beginTransaction();
        try{
            $watched = Course::find($this->course_id)->watched;
            $course = Course::find($this->course_id);
            $course->timestamps = false;
            $course->watched = $watched + 1;
            $course->save();
            DB::commit();
            $course->timestamps = true;
        }catch(\Exception $e){
            log::info($e);
            DB::rollback();
        }
    }
    public function addVisitorCount(){
        DB::beginTransaction();
        try{
            if(!Session::has("visitor_".$this->course_id."_id")){
                $visitorId = uniqid();
                Session::put("visitor_".$this->course_id."_id", $visitorId);
                $visitor = (int)Course::find($this->course_id)->visitor;
                $course = Course::find($this->course_id);
                $course->timestamps  = false;
                $course->visitor = $visitor + 1;
                $course->save();
                $course->timestamps  = true;
            }
            DB::commit();
        }catch(\Exception $e){
            log::info($e);
            DB::rollback();
        }
        
    }
    public function onSubmit(){
        $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                $this->dispatchBrowserEvent('reloadCaptcha');
                $this->captcha = '';
            });
        })->validate([
            'name' => 'required',
            'phone' => 'required',
            'school' => 'required',
            'grade' => 'required',
            'content' => 'required',
            'captcha' => 'required|captcha',
        ], [
            'name.required'=>'請輸入姓名',
            'phone.required'=>'請輸入連絡電話',
            'school.required'=>'請輸入就讀學校',
            'grade.required'=>'請輸入年級',
            'content.required'=>'請輸入內容',
            'captcha.required'=>'請輸入驗證碼',
            'captcha.captcha'=>'驗證碼輸入錯誤',
        ]);
        try{
            SendMailQueueJob::dispatch(
                [
                    'name'=> $this->name,
                    'phone'=> $this->phone, 
                    'grade'=> $this->grade,
                    'school'=> $this->school,
                    'content'=>$this->content,
                    'course'=>$this->courseName,
                ],
            );
            session()->flash('success', "發送成功！");
        }catch (Exception $e) {
            session()->flash('error', "Message could not be sent. Mailer Error");
        }
        
        $this->loading = false;
        
        $this->dispatchBrowserEvent('reloadCaptcha');
        $this->clearVar();
    }
    public function storeMail(){
        $letter = Letter::create([
            'name'=> $this->name,
            'phone'=> $this->phone, 
            'grade'=> $this->grade,
            'school'=> $this->school,
            'content'=>$this->content,
        ]);
        return $letter;
    }
    public function render()
    {
        $course = Course::where('slug', $this->slug)->first();
        $tags = json_decode($course->tags, true);
        $this->courseName = $course->title;
        $courses = Course::where('hidden', false)->orderby('updated_at', 'desc')->get();
        $hot_courses = Course::where('hidden', false)->orderby('visitor', 'desc')->get()->take(3);
        $likeCourses = Course::where([['hidden', false], ['category_id', $course->category_id]])->get()->take(3);
        return view('livewire.course-detail-component', ['course'=>$course, 'tags'=>$tags, 'courses'=>$courses, 'hot_courses'=>$hot_courses, 'likeCourses'=>$likeCourses])->layout('layouts.base');
    }
}
