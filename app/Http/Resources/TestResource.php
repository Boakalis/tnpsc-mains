<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Log;
class TestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'exam_id' => $this->exam_id,
            'exam' => $this->exam,
            'weeks' => $this->weeks_wise,
            'purchased' => $this->purchased,
        ];
    }
}
