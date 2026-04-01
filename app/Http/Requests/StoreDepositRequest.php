<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepositRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $max = (float) config('referral.deposit.max_amount', 10000000);

        return [
            'amount' => ['required', 'numeric', 'min:0.01', 'max:'.$max],
            'currency_code' => ['nullable', 'string', 'size:3'],
            'reference' => ['nullable', 'string', 'max:64'],
            'meta' => ['nullable', 'array'],
            'meta.ewallet' => ['nullable', 'string', 'max:32'],
            'meta.channel' => ['nullable', 'string', 'max:32'],
        ];
    }
}
