<?php
namespace App\Http\Requests\Wallet;
use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
{
    public const USER_ID = "user_id";
    public const AMOUNT = "amount";
    public const COMMENT = "comment";
    public function rules(): array
    {
        return [
            self::USER_ID => [
                'required',
                'integer',
                'exists:users,id'
            ],
            self::AMOUNT  => [
                'required',
                'numeric',
                'gt:0'
            ],
            self::COMMENT => [
                'nullable',
                'string',
                'max:255'
            ],
        ];
    }

    public function getUserId(): int
    {
        return $this->get(self::USER_ID);
    }
    public function getAmount(): int
    {
        return $this->get(self::AMOUNT);
    }
    public function getComment(): string
    {
        return $this->get(self::COMMENT);
    }
}
