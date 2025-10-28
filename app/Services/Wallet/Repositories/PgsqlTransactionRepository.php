<?php
namespace App\Services\Wallet\Repositories;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PgsqlTransactionRepository implements TransactionReadRepositoryInterface, TransactionWriteRepositoryInterface
{
    public function add(int $userId, string $type, string $amount, ?string $comment, ?int $relatedUserId, string $operationId): Transaction
    {
        return Transaction::create([
            'user_id' => $userId,
            'type' => $type,
            'amount' => $amount,
            'comment' => $comment,
            'related_user_id' => $relatedUserId,
            'operation_id' => $operationId,
        ]);
    }

    public function listByUser(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return Transaction::query()
            ->where('user_id', $userId)
            ->latest('id')
            ->paginate($perPage);
    }
}
