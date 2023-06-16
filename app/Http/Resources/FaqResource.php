<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
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
            'question'=>$this->question,
            'content'=>$this->content,
            'hidden'=>$this->hidden,
            'updated_at'=>(new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];    
    }
}
