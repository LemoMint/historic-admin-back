<?php

namespace App\Http\Requests\Publication;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PublicationSortRequest extends FormRequest
{
    private const SORT_ORDERS = ['ASC', 'DESC'];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '_sortBy' => ['nullable'],
            '_sortOrder' => ['nullable', Rule::in(self::SORT_ORDERS)],
            '_search' => ['nullable']
        ];
    }
}
