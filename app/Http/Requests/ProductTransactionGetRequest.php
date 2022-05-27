<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductTransactionGetRequest extends FormRequest
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
            'filter.product_id' => 'integer|between:-9223372036854775807,9223372036854775807',
            'filter.created_at' => 'date',
            'filter.updated_at' => 'date',
            'filter.product_transactions\.id' => 'integer|between:0,18446744073709551615',
            'filter.product_transactions\.transaction_id' => 'integer|between:-9223372036854775807,9223372036854775807',
            'filter.product_transactions\.product_id' => 'integer|between:-9223372036854775807,9223372036854775807',
            'filter.product_transactions\.created_at' => 'date',
            'filter.product_transactions\.updated_at' => 'date',
            'filter.transaction\.id' => 'integer|between:0,18446744073709551615',
            'filter.transaction\.user_id' => 'integer|between:-9223372036854775807,9223372036854775807',
            'filter.transaction\.qty_transaction' => 'integer|between:-2147483647,2147483647',
            'filter.transaction\.subtotal_products' => 'integer|between:-2147483647,2147483647',
            'filter.transaction\.total_price' => 'integer|between:-2147483647,2147483647',
            'filter.transaction\.status' => 'string|min:2|max:255',
            'filter.transaction\.created_at' => 'date',
            'filter.transaction\.updated_at' => 'date',
            'filter.product\.id' => 'integer|between:0,18446744073709551615',
            'filter.product\.label' => 'string|min:2|max:255',
            'filter.product\.qty' => 'integer|between:-2147483647,2147483647',
            'filter.product\.price' => 'integer|between:-2147483647,2147483647',
            'filter.product\.size' => 'integer|between:-2147483647,2147483647',
            'filter.product\.detail' => 'string|min:2|max:65535',
            'filter.product\.created_at' => 'date',
            'filter.product\.updated_at' => 'date',
            'filter.product\.deleted_at' => 'date',
            'filter.product\.category' => 'string|min:2|max:255',
            'page.number' => 'integer|min:1',
            'page.size' => 'integer|between:1,100',
            'search' => 'nullable|string|min:3|max:60',
        ];
    }
}
