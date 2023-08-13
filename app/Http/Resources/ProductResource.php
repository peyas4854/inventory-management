<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'price'       => $this->price,
            'in_stock'       => $this->stock ? $this->stock->quantity:0,
            'description' => $this->description,
            'image'       => $this->image ? Storage::disk('public')->url("products/{$this->image}"):null,
        ];
    }
}
