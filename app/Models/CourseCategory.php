<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CourseCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'grade', 'created_by', 'updated_by'];


    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
