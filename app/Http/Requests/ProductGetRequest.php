<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductGetRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'filter.id' => 'integer|between:0,18446744073709551615',
            'filter.transaction_id' => 'integer|between:-9223372036854775807,9223372036854775807',
            'filter.label' => 'string|min:2|max:255',
            'filter.qty' => 'integer|between:-2147483647,2147483647',
            'filter.price' => 'integer|between:-2147483647,2147483647',
            'filter.size' => 'integer|between:-2147483647,2147483647',
            'filter.detail' => 'string|min:2|max:65535',
            'filter.created_at' => 'date',
            'filter.updated_at' => 'date',
            'filter.deleted_at' => 'date',
            'filter.products\.id' => 'integer|between:0,18446744073709551615',
            'filter.products\.transaction_id' => 'integer|between:-9223372036854775807,9223372036854775807',
            'filter.products\.label' => 'string|min:2|max:255',
            'filter.products\.qty' => 'integer|between:-2147483647,2147483647',
            'filter.products\.price' => 'integer|between:-2147483647,2147483647',
            'filter.products\.size' => 'integer|between:-2147483647,2147483647',
            'filter.products\.detail' => 'string|min:2|max:65535',
            'filter.products\.created_at' => 'date',
            'filter.products\.updated_at' => 'date',
            'filter.products\.deleted_at' => 'date',
            'filter.transaction\.id' => 'integer|between:0,18446744073709551615',
            'filter.transaction\.user_id' => 'integer|between:-9223372036854775807,9223372036854775807',
            'filter.transaction\.qty_transaction' => 'integer|between:-2147483647,2147483647',
            'filter.transaction\.subtotal_products' => 'integer|between:-2147483647,2147483647',
            'filter.transaction\.total_price' => 'integer|between:-2147483647,2147483647',
            'filter.transaction\.status' => 'string|min:2|max:255',
            'filter.transaction\.created_at' => 'date',
            'filter.transaction\.updated_at' => 'date',
            'page.number' => 'integer|min:1',
            'page.size' => 'integer|between:1,100',
            'search' => 'nullable|string|min:3|max:60',
        ];
    }
}
