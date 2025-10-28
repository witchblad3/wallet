<?php
namespace App\Services\Wallet\Repositories;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TransactionReadRepositoryInterface
{
    public function listByUser(int $userId, int $perPage = 20): LengthAwarePaginator;
}
