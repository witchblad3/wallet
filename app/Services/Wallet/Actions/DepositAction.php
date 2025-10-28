<?php
namespace App\Services\Wallet\Actions;

use Illuminate\Support\Facades\DB;
use App\Services\Wallet\Dto\DepositData;
use App\Services\Wallet\Repositories\{AccountWriteRepositoryInterface, TransactionWriteRepositoryInterface};
use Illuminate\Support\Str;

class DepositAction
{
    public function __construct(
        private AccountWriteRepositoryInterface $accounts,
        private TransactionWriteRepositoryInterface $tx
    ) {}

    public function run(DepositData $data)
    {
        return DB::transaction(function () use ($data) {
            $operationId = Str::uuid();
            $account = $this->accounts->increaseBalance($data->userId, $data->amount);
            $this->tx->add($data->userId, 'deposit', $data->amount, $data->comment, null, $operationId);
            return $account;
        });
    }
}
