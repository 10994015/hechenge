<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Banner extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'url', 'image', 'image_mime', 'image_size', 'hidden', 'category_id', 'created_by', 'updated_by'];

}
