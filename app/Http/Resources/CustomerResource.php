<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email??'not has email',
            'phone' => $this->phone??'not has phone',
            'gender' => $this->gender,
            'created_by'=>$this->createdBy->name??'not has created_by',
        ];
    }
}
