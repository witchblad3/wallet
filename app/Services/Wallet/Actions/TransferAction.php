<?php
namespace App\Services\Wallet\Actions;

use App\Enum\Transaction\TransactionTypeEnum;
use Illuminate\Support\Facades\DB;
use App\Services\Wallet\Dto\TransferData;
use App\Services\Wallet\Repositories\{
    AccountWriteRepositoryInterface,
    TransactionWriteRepositoryInterface
};
use App\Services\Wallet\Exceptions\InsufficientFundsException;
use Illuminate\Support\Str;

class TransferAction
{
    public function __construct(
        private AccountWriteRepositoryInterface $accounts,
        private TransactionWriteRepositoryInterface $tx
    ) {}

    public function run(TransferData $data): array
    {
        DB::transaction(function () use ($data) {
            $opId = (string) Str::uuid();

            try {
                $this->accounts->transfer(
                    $data->fromUserId,
                    $data->toUserId,
                    $data->amount
                );
            } catch (\Throwable $e) {
                if ($e->getMessage() === 'INSUFFICIENT_FUNDS') {
                    throw new InsufficientFundsException();
                }
                throw $e;
            }

            $this->tx->add(
                $data->fromUserId,
                TransactionTypeEnum::TRANSFER_OUT->value,
                $data->amount,
                $data->comment,
                $data->toUserId,
                $opId
            );

            $this->tx->add(
                $data->toUserId,
                TransactionTypeEnum::TRANSFER_IN->value,
                $data->amount,
                $data->comment,
                $data->fromUserId,
                $opId
            );
        });

        return [
            'from_user_id' => $data->fromUserId,
            'to_user_id' => $data->toUserId,
            'amount' => $data->amount,
            'comment'=> $data->comment,
        ];
    }
}
