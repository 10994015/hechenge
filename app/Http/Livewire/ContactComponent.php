<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactComponent extends Component
{
    public $name;
    public $phone;
    public $school;
    public $grade;
    public $content;
    public $captcha;
    public $loading;
    public $course=  "英文課";
    public function clearVar(){
        $this->name = "";
        $this->phone = "";
        $this->school = "";
        $this->grade = "";
        $this->content = "";
        $this->captcha = "";
        $this->loading = "";
        $this->course = "";
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
  
            $mail->addAddress('a0938599191@gmail.com');
  
            $mail->isHTML(true);
            $mail->Subject = "赫成教育補習班詢問信件";
            $mail->Body = '寄信人聯絡電話:' . $this->phone .'<br />';
            $mail->Body .= '寄信人姓名:' . $this->name .'<br />';
            $mail->Body .= '寄信人年級:' . $this->grade .'<br />';
            $mail->Body .= '寄信人就讀學校:' . $this->school .'<br />';
            $mail->Body .= '詢問課程:' . $this->course .'<br />';
            $mail->Body .= '內容:' . $this->content;
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
        $courses = Course::where('hidden', false)->get();
        return view('livewire.contact-component', ['courses'=>$courses])->layout('layouts.base');
    }
}
