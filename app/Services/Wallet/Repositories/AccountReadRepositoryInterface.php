<?php
namespace App\Services\Wallet\Repositories;
use App\Models\Account;

interface AccountReadRepositoryInterface
{
    public function findByUserId(int $userId): ?Account;
}
