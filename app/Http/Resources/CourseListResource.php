<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseListResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'image_url'=>$this->image ?? '',
            'hidden'=>$this->hidden,
            'focus'=>$this->focus,
            'tags'=>$this->tags ?? '',
            'grade'=>$this->grade,
            'watched'=>$this->watched,
            'category_id'=>$this->category_id,
            'updated_at'=>(new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
