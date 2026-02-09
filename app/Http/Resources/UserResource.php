<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            // Add any other user attributes you want to expose
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // Example of adding a custom attribute
            'is_admin' => $this->when($this->role === 'admin', true),
        ];
    }
}