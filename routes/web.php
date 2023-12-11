<?php

use App\Http\Controllers\CaptchaController;
use App\Http\Livewire\ContactComponent;
use App\Http\Livewire\CourseAllComponent;
use App\Http\Livewire\CourseComponent;
use App\Http\Livewire\CourseDetailComponent;
use App\Http\Livewire\FaqComponent;
use App\Http\Livewire\HomeComponent;
use App\Http\Livewire\MaintainComponent;
use App\Http\Livewire\NewDetailComponent;
use App\Http\Livewire\NewsComponent;
use App\Http\Livewire\SearchCoursesComponent;
use App\Http\Livewire\StudentComponent;
use App\Http\Livewire\TeacherComponent;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeComponent::class);
// Route::middleware([''])->group(function(){
    Route::get('/contact', ContactComponent::class);
    Route::get('/news', NewsComponent::class);
    Route::get('/new-detail/{slug}', NewDetailComponent::class);
    // Route::get('/courses', CourseComponent::class);
    Route::get('/courses/{category}', CourseComponent::class);
    Route::get('/courses', CourseAllComponent::class);
    Route::get('/course-detail/{slug}', CourseDetailComponent::class);
    Route::get('/course-search/{value}', SearchCoursesComponent::class);
    Route::get('/teachers', TeacherComponent::class);
    Route::get('/students', StudentComponent::class);
// });

Route::get('/maintain', MaintainComponent::class);
// Route::get('/faq', FaqComponent::class);



Route::get('/reload-captcha', [CaptchaController::class, 'reloadCaptcha'] );
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
