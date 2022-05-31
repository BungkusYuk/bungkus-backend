<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionSaveRequest extends FormRequest
{
    /**
     * Determine if the current user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
//        return (auth()->guard('api')->check() || auth()->guard('cms-api')->check());
    }

    public function prepareForValidation(): void
    {
        $userId = auth()->user()?->id;
        $this->merge(['user_id' => $userId]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => 'nullable|integer|between:-9223372036854775807,9223372036854775807',
            'qty_transaction' => 'required|integer|between:-2147483647,2147483647',
            'subtotal_products' => 'required|integer|between:-2147483647,2147483647',
            'total_price' => 'required|integer|between:-2147483647,2147483647',
            'status' => 'required|string|min:2|max:255',
        ];
    }
}
