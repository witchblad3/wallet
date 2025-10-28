<?php
namespace App\Services\Wallet\Actions\Support;

readonly class OperationResult
{
    public function __construct(
        public int   $httpCode,
        public array $payload
    ) {}

    public static function ok(array $payload = []): self
    { return new self(200, $payload ?: ['status' => 'ok']); }

    public static function conflict(string $message): self
    { return new self(409, ['message' => $message]); }

    public static function notFound(string $message = 'Не найдено'): self
    { return new self(404, ['message' => $message]); }

    public static function validation(string $message): self
    { return new self(422, ['message' => $message]); }
}
