<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReceiptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'receipt_id' => $this['id'],
            'receipt_number' => $this['trx_number'],
            'date' => $this['date'],
            'amount' => $this['amount'],
            'related_invoice'=> $this->getEnrollment?->enrollment_number ?? "NA",
            'currency'=> '$',
            'currency_name'=> 'USD',
        ];
    }
}
