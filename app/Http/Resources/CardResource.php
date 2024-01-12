<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'name' => $this->name,
            'per_price' => $this->per_price,
            'price' => $this->price,
            'selected' => $this->selected,
            'img' => $this->img,
            'total' => $this->total,
            'is_active' => $this->is_active,
            'type'=> $this->type,
            'rarity' => $this->rarity,
        ];
    }
}
