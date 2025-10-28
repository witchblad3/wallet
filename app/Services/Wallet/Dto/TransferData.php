<?php

namespace App\Services\Wallet\Dto;

use Spatie\LaravelData\Data;
use App\Http\Requests\Wallet\TransferRequest;

class TransferData extends Data
{
    public int $fromUserId;
    public int $toUserId;
    public string $amount;
    public ?string $comment;

    public static function fromRequest(TransferRequest $request): self
    {
        return self::from([
            'fromUserId' => $request->getFromUserId(),
            'toUserId' => $request->getToUserId(),
            'amount' => $request->getAmount(),
            'comment' => $request->getComment(),
        ]);
    }
}
