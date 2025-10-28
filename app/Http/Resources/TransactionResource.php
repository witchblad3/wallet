<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'amount' => $this->amount,
            'comment' => $this->comment,
            'related_user_id' => $this->related_user_id,
            'operation_id' => $this->operation_id,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
