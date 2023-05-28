<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TeacherCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'created_by', 'updated_by'];
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
}
