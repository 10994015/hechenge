<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\Minute;
use Illuminate\Console\Command;

class DailyMinutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:minutes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $courses = Course::where('deleted_at', null)->get();
        foreach($courses as $course){
            Minute::create([
                'date_at'=>date('Y-m-d'),
                'course_id' => $course->id,
                'minutes'=>0
            ]);
        }
    }
}
