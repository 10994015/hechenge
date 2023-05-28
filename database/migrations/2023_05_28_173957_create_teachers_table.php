<?php

use App\Models\TeacherCategory;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('subname', 255)->nullable();
            $table->string('slug', 2000);
            $table->string('image', 2000)->nullable();
            $table->string('image_mime')->nullable();
            $table->integer('image_size')->nullable();
            $table->string('title1', 255)->nullable();
            $table->longText('content1')->nullable();
            $table->string('title2', 255)->nullable();
            $table->longText('content2')->nullable();
            $table->string('title3', 255)->nullable();
            $table->longText('content3')->nullable();
            $table->string('title4', 255)->nullable();
            $table->longText('content4')->nullable();
            $table->string('title5', 255)->nullable();
            $table->longText('content5')->nullable();
            $table->foreignIdFor(TeacherCategory::class, 'category_id')->nullable()->onDelete('set null');
            $table->boolean('hidden')->default(false);
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->softDeletes();
            $table->foreignIdFor(User::class, 'deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teachers');
    }
}
