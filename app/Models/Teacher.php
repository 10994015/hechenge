<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;
    protected $fillable = ['name', 'subname', 'title1', 'content1', 'title2', 'content2', 'title3', 'content3', 'title4', 'content4', 'title5', 'content5', 'image', 'image_mime', 'image_size', 'hidden', 'category_id', 'created_by', 'updated_by'];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
    public function category()
    {
        return $this->belongsTo(TeacherCategory::class);
    }
}
