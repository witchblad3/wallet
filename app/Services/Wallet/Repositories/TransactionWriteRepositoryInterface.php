<?php
namespace App\Services\Wallet\Repositories;
use App\Models\Transaction;

interface TransactionWriteRepositoryInterface
{
    public function add(
        int $userId,
        string $type,
        string $amount,
        ?string $comment,
        ?int $relatedUserId,
        string $operationId
    ): Transaction;
}
