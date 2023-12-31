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
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'in_stock' => $this->stockAvailable($this->in_stock_sum_quantity,$this->out_stock_sum_quantity),
            'description' => $this->description,
            'image' => $this->image ? Storage::disk('public')->url("products/{$this->image}") : null,
        ];
    }
    public function stockAvailable($inStock,$outStock){
        return $inStock - $outStock;
    }

}
