<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'address_title' => $this->address_title,
            'subtotal' => $this->subtotal,
            'grand_total' => $this->grand_total,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'payment_gateway' => $this->payment_gateway,
            'delivery_cost' => $this->delivery_cost,
            'order_note' => $this->order_note,
            'payment_trx_id' => $this->payment_trx_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'payments' => $this->whenLoaded('payments'), // Assuming Payment model doesn't need a specific resource for now
            'due_amount' => $this->due(),
            'paid_amount' => $this->paid(),
        ];
    }
}