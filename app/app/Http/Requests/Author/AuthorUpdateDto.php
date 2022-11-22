<?php

namespace App\Http\Requests\Author;

use App\Http\Requests\AbstractApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class AuthorUpdateDto extends AbstractApiRequest
{
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
            'name' => ['required', 'string'],
            'surname' => ['required', 'string'],
            'patronymic_name' => ['nullable', 'string']
        ];
    }
}
