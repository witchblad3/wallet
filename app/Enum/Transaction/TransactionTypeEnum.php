<?php

namespace App\Enum\Transaction;

enum TransactionTypeEnum: string
{
    case DEPOSIT = 'deposit';
    case WITHDRAW = 'withdraw';
    case TRANSFER_IN = 'transfer_in';
    case TRANSFER_OUT = 'transfer_out';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
