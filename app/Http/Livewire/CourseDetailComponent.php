<?php

namespace App\Http\Livewire;

use App\Models\Course;
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
    public function mount($slug){
        $this->slug = $slug;
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
