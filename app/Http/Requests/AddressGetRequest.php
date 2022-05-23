<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressGetRequest extends FormRequest
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
            'filter.user_id' => 'integer|between:-9223372036854775807,9223372036854775807',
            'filter.street' => 'string|min:2|max:255',
            'filter.created_at' => 'date',
            'filter.updated_at' => 'date',
            'filter.deleted_at' => 'date',
            'filter.addresses\.id' => 'integer|between:0,18446744073709551615',
            'filter.addresses\.user_id' => 'integer|between:-9223372036854775807,9223372036854775807',
            'filter.addresses\.street' => 'string|min:2|max:255',
            'filter.addresses\.created_at' => 'date',
            'filter.addresses\.updated_at' => 'date',
            'filter.addresses\.deleted_at' => 'date',
            'filter.user\.id' => 'integer|between:0,18446744073709551615',
            'filter.user\.name' => 'string|min:2|max:255',
            'filter.user\.email' => 'string|email|min:11|max:255',
            'filter.user\.phone' => 'string|regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/|max:255',
            'filter.user\.password' => 'string|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/',
            'filter.user\.remember_token' => 'string|min:2|max:100',
            'filter.user\.created_at' => 'date',
            'filter.user\.updated_at' => 'date',
            'filter.user\.deleted_at' => 'date',
            'page.number' => 'integer|min:1',
            'page.size' => 'integer|between:1,100',
            'search' => 'nullable|string|min:3|max:60',
        ];
    }
}
