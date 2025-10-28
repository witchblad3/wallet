<?php

namespace App\Services\Wallet\Dto;

use Spatie\LaravelData\Data;
use App\Http\Requests\Wallet\DepositRequest;

class DepositData extends Data
{
    public int $userId;
    public string $amount;
    public ?string $comment;

    public static function fromRequest(DepositRequest $request): self
    {
        return self::from([
            'userId' => $request->getUserId(),
            'amount' => $request->getAmount(),
            'comment' => $request->getComment(),
        ]);
    }
}
