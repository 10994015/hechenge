<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
class LetterResource extends JsonResource
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
            'phone'=>$this->phone,
            'grade'=>$this->grade,
            'school'=>$this->school,
            'content'=>$this->content,
            'created_at'=>(new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'ago'=>Carbon::parse($this->created_at)->diffForHumans(),
        ];    
    }
}
