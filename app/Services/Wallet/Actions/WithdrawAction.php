<?php
namespace App\Services\Wallet\Actions;


use App\Services\Wallet\Dto\WithdrawData;
use App\Services\Wallet\Repositories\{AccountWriteRepositoryInterface, TransactionWriteRepositoryInterface};
use App\Services\Wallet\Exceptions\InsufficientFundsException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WithdrawAction
{
    public function __construct(
        private AccountWriteRepositoryInterface $accounts,
        private TransactionWriteRepositoryInterface $tx
    ) {}

    public function run(WithdrawData $data)
    {
        return DB::transaction(function () use ($data) {
            $operationId = Str::uuid();

            $account = $this->accounts->withdrawIfEnough($data->userId, $data->amount);
            if (!$account) {
                throw new InsufficientFundsException();
            }

            $this->tx->add($data->userId, 'withdraw', $data->amount, $data->comment, null, $operationId);

            return $account;
        });
    }
}
