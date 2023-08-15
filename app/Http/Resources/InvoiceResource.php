<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'date'=>$this->date,
            'invoice_no'=>$this->invoice_no,
            'supplier'=>'Test Supplire 1 ', // TODO : make dynamic later
            'sub_total'=>$this->sub_total
        ];
    }
}
