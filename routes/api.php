<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseTagController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MinuteController;
use App\Http\Controllers\SortController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherCategoryController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/upload-images', [AuthController::class, 'uploadImage']);

Route::middleware(['auth:sanctum', 'admin'])->group(function(){
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/updateUser', [AuthController::class, 'updateUser']);

    //upload image

    //articles
    Route::apiResource('articles', ArticleController::class);
    Route::post('/isExistArticle', [ArticleController::class, 'isExistArticle']);
    Route::post('/articleItems', [ArticleController::class, 'deleteItems']);
    //article categoires
    Route::get('/articleCategories', [ArticleCategoryController::class, 'index']);
    Route::post('/articleCategory', [ArticleCategoryController::class, 'store']);
    Route::delete('/articleCategory/{id}', [ArticleCategoryController::class, 'destroy']);
    Route::post('/articleCategoryItems', [ArticleCategoryController::class, 'deleteItems']);
    //banners
    Route::apiResource('banners', BannerController::class);
    Route::post('/isExistBanner', [BannerController::class, 'isExistBanner']);
    Route::post('/bannerItems', [BannerController::class, 'deleteItems']);
     //courses
     Route::apiResource('courses', CourseController::class);
     Route::post('/isExistCourse', [CourseController::class, 'isExistCourse']);
     Route::post('/courseItems', [CourseController::class, 'deleteItems']);
     //course categoires
     Route::get('/courseCategories', [CourseCategoryController::class, 'index']);
     Route::post('/courseCategory', [CourseCategoryController::class, 'store']);
     Route::delete('/courseCategory/{id}', [CourseCategoryController::class, 'destroy']);
     Route::post('/courseCategoryItems', [CourseCategoryController::class, 'deleteItems']);
      //course tags
      Route::get('/courseTags', [CourseTagController::class, 'index']);
      Route::post('/courseTag', [CourseTagController::class, 'store']);
      Route::delete('/courseTag/{id}', [CourseTagController::class, 'destroy']);
      Route::post('/courseTagItems', [CourseTagController::class, 'deleteItems']);
      //teacher categoires
     Route::get('/teacherCategories', [TeacherCategoryController::class, 'index']);
     Route::post('/teacherCategory', [TeacherCategoryController::class, 'store']);
     Route::delete('/teacherCategory/{id}', [TeacherCategoryController::class, 'destroy']);
     Route::post('/teacherCategoryItems', [TeacherCategoryController::class, 'deleteItems']);
    //teachers
    Route::apiResource('teachers', TeacherController::class);
    Route::post('/isExistTeacher', [TeacherController::class, 'isExistTeacher']);
    Route::post('/teacherItems', [TeacherController::class, 'deleteItems']);
    //students
    Route::apiResource('students', StudentController::class);
    Route::post('/isExistStudent', [StudentController::class, 'isExistStudent']);
    Route::post('/studentItems', [StudentController::class, 'deleteItems']);
    //faqs
    Route::apiResource('faqs', FaqController::class);
    Route::post('/isExistFaq', [FaqController::class, 'isExistFaq']);
    Route::post('/faqItems', [FaqController::class, 'deleteItems']);
    //minutes
    Route::apiResource('minutes', MinuteController::class);
    //letters
    Route::apiResource('letters', LetterController::class);
    Route::post('/isExistLetter', [LetterController::class, 'isExistLetter']);
    Route::post('/letterItems', [LetterController::class, 'deleteItems']);

    //logs
    Route::get('/logs', [LogController::class, 'index']);


    //sort
    Route::post('/sort-teachers', [SortController::class, 'teachers']);
    Route::post('/sort-banners', [SortController::class, 'banners']);

});

Route::post('/login', [AuthController::class, 'login']);