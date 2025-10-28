<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\{
    Wallet\DepositRequest,
    Wallet\TransferRequest,
    Wallet\WithdrawRequest,
};
use App\Services\Wallet\Actions\{DepositAction, TransferAction, WithdrawAction};
use App\Services\Wallet\Dto\{DepositData, TransferData, WithdrawData};
use Illuminate\Http\JsonResponse;

class OperationController extends Controller
{
    public function deposit(DepositRequest $request, DepositAction $action): JsonResponse
    {
        $dto = DepositData::fromRequest($request);
        $account = $action->run($dto);

        return response()->json([
            'user_id' => $account->user_id,
            'balance' => $account->balance,
        ], 200);
    }

    public function withdraw(WithdrawRequest $request, WithdrawAction $action): JsonResponse
    {
        $dto = WithdrawData::fromRequest($request);
        $res = $action->run($dto);
        return response()->json($res);
    }

    public function transfer(TransferRequest $request, TransferAction $action): JsonResponse
    {
        $dto = TransferData::fromRequest($request);
        $res = $action->run($dto);
        return response()->json($res, 200);
    }
}
