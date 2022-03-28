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
            /** @phpstan-ignore-next-line */
            'user_id' => $this->user_id,
            /** @phpstan-ignore-next-line */
            'patient_height' => $this->patient_height,
            /** @phpstan-ignore-next-line */
            'patient_weight' => $this->patient_weight,
            /** @phpstan-ignore-next-line */
            'patient_phone' => $this->patient_phone,
            /** @phpstan-ignore-next-line */
            'patient_other_info' => $this->patient_other_info,
        ];
    }
}
