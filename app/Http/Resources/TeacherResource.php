<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'name'=>$this->name,
            'subname'=>$this->subname ?? '',
            'slug'=>$this->slug,
            'title1'=>$this->title1 ?? '',
            'content1'=>$this->content1 ?? '',
            'title2'=>$this->title2 ?? '',
            'content2'=>$this->content2 ?? '',
            'title3'=>$this->title3 ?? '',
            'content3'=>$this->content3 ?? '',
            'title4'=>$this->title4 ?? '',
            'content4'=>$this->content4 ?? '',
            'title5'=>$this->title5 ?? '',
            'content5'=>$this->content5 ?? '',
            'image_url'=>$this->image ?? '',
            'hidden'=>$this->hidden ? true : false,
            'category_id'=>$this->category_id,
            'created_at'=>(new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at'=>(new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
