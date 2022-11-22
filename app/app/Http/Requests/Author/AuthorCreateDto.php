<?php

namespace App\Http\Requests\Author;

use Illuminate\Validation\Rule;

class AuthorCreateDto extends AuthorUpdateDto
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
        return array_merge_recursive(parent::rules(),  [
            'name' => [Rule::unique('authors')->where('surname', $this->surname)->where('patronymic_name', $this->patronymic_name)]
        ]);
    }
}
