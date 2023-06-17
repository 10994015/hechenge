<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Minute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CourseDetailComponent extends Component
{
    public $name;
    public $phone;
    public $school;
    public $grade;
    public $content;
    public $captcha;
    public $loading;
    public $courseName = "英文課";
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
        $this->grade = "";
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
                Session::put('visitor_id', $visitorId);
                $visitor = (int)Course::find($this->course_id)->visitor;
                Course::find($this->course_id)->update([
                    'visitor'=> $visitor + 1
                ]);
            }
            DB::commit();
        }catch(\Exception $e){
            log::info($e);
            DB::rollback();
        }
        
    }
    public function onSubmit(){
        $this->validate([
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
        $mail = new PHPMailer(true);
        
        try{
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'cy9577@gmail.com';
            $mail->Password = 'grqrdvmjhszzvafa';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
  
            $mail->setFrom('cy9577@gmail.com');
  
            $mail->addAddress('happiness000312@gmail.com');
  
            $mail->isHTML(true);
  
            $mail->Subject = "赫成教育補習班詢問信件";
            $mail->Body = '寄信人聯絡電話:' . $this->phone .'<br />';
            $mail->Body .= '寄信人姓名:' . $this->name .'<br />';
            $mail->Body .= '寄信人年級:' . $this->grade .'<br />';
            $mail->Body .= '寄信人就讀學校:' . $this->school .'<br />';
            $mail->Body .= '詢問課程:' . $this->courseName .'<br />';
            $mail->Body .= '內容:' . $this->content;
            $mail->send();
  
            $mail->send();

            session()->flash('success', "發送成功！");

            $this->loading = false;
            $this->clearVar();
        }catch (Exception $e) {
            session()->flash('error', "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
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
