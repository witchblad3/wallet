<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BalanceResource extends JsonResource
{
    public function toArray($request)
    {
        return ['user_id' => $this->user_id, 'balance' => $this->balance];
    }
}
