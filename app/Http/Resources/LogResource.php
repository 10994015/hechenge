<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
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
            'username'=>$this->username,
            'action'=>$this->action,
            'to'=>$this->to,
            'to_id'=>$this->to_id,
            'content'=>$this->content,
            'created_by'=>$this->created_by,
            'created_at'=>(new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
        ];    
    }
}
