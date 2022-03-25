<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'user_id' => $this->user_id,
            'patient_height' => $this->patient_height,
            'patient_weight' => $this->patient_weight,
            'patient_phone' => $this->patient_phone,
            'patient_other_info' => $this->patient_other_info,
        ];
    }
}
