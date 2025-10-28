<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{OperationController, BalanceController};

Route::get('/health', fn () => response()->json(['status' => 'ok']));
Route::post('/deposit',  [OperationController::class, 'deposit']);
Route::post('/withdraw', [OperationController::class, 'withdraw']);
Route::post('/transfer', [OperationController::class, 'transfer']);
Route::get('/balance/{user}', [BalanceController::class, 'show']);
