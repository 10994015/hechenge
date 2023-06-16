<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "students";
    protected $fillable = ['name', 'content', 'url', 'image', 'image_mime', 'image_size', 'hidden', 'created_by', 'updated_by'];

}
