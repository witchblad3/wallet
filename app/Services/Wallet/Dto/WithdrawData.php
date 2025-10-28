<?php

namespace App\Services\Wallet\Dto;

use Spatie\LaravelData\Data;
use App\Http\Requests\Wallet\WithdrawRequest;

class WithdrawData extends Data
{
    public int $userId;
    public string $amount;
    public ?string $comment;

    public static function fromRequest(WithdrawRequest $request): self
    {
        return self::from([
            'userId'  => $request->getUserId(),
            'amount'  => $request->getAmount(),
            'comment' => $request->getComment(),
        ]);
    }
}
