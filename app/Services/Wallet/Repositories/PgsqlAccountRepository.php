<?php
namespace App\Services\Wallet\Repositories;

use App\Models\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Exception;

class PgsqlAccountRepository implements AccountReadRepositoryInterface, AccountWriteRepositoryInterface
{
    public function findByUserId(int $userId): ?Account
    {
        return Account::query()->where('user_id', $userId)->first();
    }

    public function createIfNotExists(int $userId): Account
    {
        return DB::transaction(function () use ($userId) {
            $acc = $this->findByUserId($userId);
            if ($acc) return $acc;
            return Account::create(['user_id' => $userId, 'balance' => '0.00']);
        });
    }

    public function increaseBalance(int $userId, string $amount): Account
    {
        $row = DB::selectOne(
            "INSERT INTO accounts (user_id, balance, created_at, updated_at)
         VALUES (:uid, :amt, now(), now())
         ON CONFLICT (user_id)
         DO UPDATE SET balance = accounts.balance + EXCLUDED.balance, updated_at = now()
         RETURNING id, user_id, balance, created_at, updated_at",
            ['uid' => $userId, 'amt' => $amount]
        );

        return Account::hydrate([$row])->first();
    }

    public function withdrawIfEnough(int $userId, string $amount): ?Account
    {
        $row = DB::selectOne(
            "UPDATE accounts SET balance = balance - :amt, updated_at = now()
         WHERE user_id = :uid AND balance >= :amt
         RETURNING id, user_id, balance, created_at, updated_at",
            ['uid' => $userId, 'amt' => $amount]
        );

        return $row ? Account::hydrate([$row])->first() : null;
    }

    public function transfer(int $fromUserId, int $toUserId, string $amount): void
    {
        DB::beginTransaction();
        try {
            $out = DB::selectOne(
                "UPDATE accounts SET balance = balance - :amt, updated_at = now()
                 WHERE user_id = :from AND balance >= :amt
                 RETURNING id",
                ['from' => $fromUserId, 'amt' => $amount]
            );
            if (!$out) {
                DB::rollBack();
                throw new \RuntimeException('INSUFFICIENT_FUNDS');
            }

            DB::statement(
                "INSERT INTO accounts (user_id, balance, created_at, updated_at)
                 VALUES (:to, :amt, now(), now())
                 ON CONFLICT (user_id)
                 DO UPDATE SET balance = accounts.balance + EXCLUDED.balance, updated_at = now()",
                ['to' => $toUserId, 'amt' => $amount]
            );

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
