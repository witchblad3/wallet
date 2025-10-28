<?php
namespace App\Services\Wallet\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class InsufficientFundsException extends HttpException
{
    public function __construct(string $message = 'Недостаточно средств для перевода')
    {
        parent::__construct(409, $message);
    }
}
