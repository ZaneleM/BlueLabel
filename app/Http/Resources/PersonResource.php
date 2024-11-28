<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'id_number' => $this->id_number,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            'birth_date' => $this->birth_date,
            'language' => new LanguageResource($this->whenLoaded('language')),
            'interests' => InterestResource::collection($this->whenLoaded('interests')),
        ];
    }
}
