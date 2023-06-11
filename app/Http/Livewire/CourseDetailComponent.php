<?php

namespace App\Http\Livewire;

use Livewire\Component;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class CourseDetailComponent extends Component
{
    public $name;
    public $email;
    public $subject;
    public $content;
    public $captcha;
    public $loading;
    public $course = "英文課";
    public function clearVar(){
        $this->name = "";
        $this->email = "";
        $this->subject = "";
        $this->content = "";
        $this->captcha = "";
        $this->loading = "";
        $this->course = "";
    }
    public function onSubmit(){
        $this->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'content' => 'required',
            'captcha' => 'required|captcha',
        ], [
            'name.required'=>'請輸入姓名',
            'email.required'=>'請輸入Email',
            'subject.required'=>'請輸入主旨',
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
  
            $mail->Subject = $this->subject;
            $mail->Body = '寄信人信箱:' . $this->email .'<br />';
            $mail->Body .= '寄信人姓名:' . $this->name .'<br />';
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
        return view('livewire.course-detail-component')->layout('layouts.base');
    }
}
