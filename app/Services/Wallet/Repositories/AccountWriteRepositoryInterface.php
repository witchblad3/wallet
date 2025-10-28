<?php
namespace App\Services\Wallet\Repositories;
use App\Models\Account;

interface AccountWriteRepositoryInterface
{
    public function createIfNotExists(int $userId): Account;
    public function increaseBalance(int $userId, string $amount): Account;
    public function withdrawIfEnough(int $userId, string $amount): ?Account;
    public function transfer(int $fromUserId, int $toUserId, string $amount): void;
}
