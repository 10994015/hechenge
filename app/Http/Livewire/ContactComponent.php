<?php

namespace App\Http\Livewire;

use App\Jobs\SendMailQueueJob;
use App\Models\Course;
use App\Models\Letter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Validation\Validator;
class ContactComponent extends Component implements ShouldQueue
{
    use Queueable;
    public $name;
    public $phone;
    public $school;
    public $grade = "高中一年級";
    public $content;
    public $captcha;
    public $loading;
    public $course;
    public function clearVar(){
        $this->name = "";
        $this->phone = "";
        $this->school = "";
        $this->grade = "高中一年級";
        $this->content = "";
        $this->captcha = "";
        $this->loading = "";
        $this->course = "";
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
                    'course'=>$this->course,
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
        $courses = Course::where('hidden', false)->get();
        return view('livewire.contact-component', ['courses'=>$courses])->layout('layouts.base');
    }
}
