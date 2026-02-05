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
            'invoice_id' => $this['id'],
            'invoice_number' => $this['enrollment_number'],
            'status'  => $this->getStatus?->name ?? "Unknown",
            'status_key'=> $this->getStatus?->key ?? "U",
            'total_amount' => $this['total_amount'],
            'received_amount' => $this['received_amount'],
            'remaining_amount' => $this['remaining_amount'],
            'date'=>\Carbon\Carbon::parse($this['created_at'])->format('d/m/Y'),
            'currency'=> '$',
            'currency_name'=> 'USD',
        ];
    }
}
