<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingSaveRequest extends FormRequest
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
            'user_id' => 'required|integer|between:-9223372036854775807,9223372036854775807',
            'product_id' => 'required|integer|between:-9223372036854775807,9223372036854775807',
            'rating' => 'required|integer|between:-2147483647,2147483647',
            'is_rating' => 'required|boolean',
        ];
    }
}
