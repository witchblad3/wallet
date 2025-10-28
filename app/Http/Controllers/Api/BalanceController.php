<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BalanceResource;
use App\Models\User;
use App\Services\Wallet\Repositories\AccountReadRepositoryInterface;

class BalanceController extends Controller
{
    public function __construct(private AccountReadRepositoryInterface $accounts) {}

    public function show(User $user)
    {
        $account = $this->accounts->findByUserId($user->id) ?? $user->account()->make(['balance' => '0.00']);
        return new BalanceResource($account);
    }
}
