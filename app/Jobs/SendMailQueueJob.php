<?php

namespace App\Jobs;

use App\Models\Letter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class SendMailQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $phone;
    protected $name;
    protected $grade;
    protected $school;
    protected $course;
    protected $content;
    protected $mail;
     public function __construct($student)
    {
        $this->phone = $student['phone'];
        $this->name = $student['name'];
        $this->grade = $student['grade'];
        $this->school = $student['school'];
        $this->course = $student['course'];
        $this->content = $student['content'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        log::info($this->name);
        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";
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
            $mail->Body = '<p>寄信人聯絡電話:' . $this->phone .'</p>';
            $mail->Body .= '<p>寄信人姓名:' . $this->name .'</p>';
            $mail->Body .= '<p>寄信人年級:' . $this->grade .'</p>';
            $mail->Body .= '<p>寄信人就讀學校:' . $this->school .'</p>';
            $mail->Body .= '<p>詢問課程:' . $this->course .'</p>';
            $mail->Body .= '<p>詢問內容:</p>' .$this->content;
            $mail->send();

            $this->storeMail();
            
        }catch (Exception $e) {
            Log::info("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
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
}
