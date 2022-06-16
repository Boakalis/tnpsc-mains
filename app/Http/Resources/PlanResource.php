<?php

namespace App\Http\Resources;

use App\Models\Exam;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' =>$this->id,
            'name' =>$this->name,
            'days' =>$this->days,
            'price' =>$this->price,
            'type' =>$this->type,
            'status' =>$this->status,
            'description' =>json_decode($this->formated,true),
            'exam' => new ExamResource($this->exam),
        ];
    }
}
