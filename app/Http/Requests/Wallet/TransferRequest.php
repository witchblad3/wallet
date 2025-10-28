<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
{
    public const FROM_USER_ID = 'from_user_id';
    public const TO_USER_ID = 'to_user_id';
    public const AMOUNT = 'amount';
    public const COMMENT = 'comment';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            self::FROM_USER_ID => [
                'required',
                'integer',
                'different:'.self::TO_USER_ID,
                'exists:users,id'
            ],
            self::TO_USER_ID => [
                'required',
                'integer',
                'exists:users,id'
            ],
            self::AMOUNT => [
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

    public function getFromUserId(): int
    {
        return $this->get(self::FROM_USER_ID);
    }

    public function getToUserId(): int
    {
        return $this->get(self::TO_USER_ID);
    }

    public function getAmount(): string
    {
        return $this->get(self::AMOUNT);
    }

    public function getComment(): ?string
    {
        return $this->get(self::COMMENT);
    }
}
