<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Wallet\Repositories\{
    AccountReadRepositoryInterface,
    AccountWriteRepositoryInterface,
    TransactionReadRepositoryInterface,
    TransactionWriteRepositoryInterface,
    PgsqlAccountRepository,
    PgsqlTransactionRepository,
};

class WalletServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(AccountReadRepositoryInterface::class, PgsqlAccountRepository::class);
        $this->app->bind(AccountWriteRepositoryInterface::class, PgsqlAccountRepository::class);
        $this->app->bind(TransactionReadRepositoryInterface::class, PgsqlTransactionRepository::class);
        $this->app->bind(TransactionWriteRepositoryInterface::class, PgsqlTransactionRepository::class);
    }
}
