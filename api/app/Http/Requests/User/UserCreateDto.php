<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;

class UserCreateDto extends UserUpdateDto
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
            'name' => [Rule::unique('users')->where('surname', $this->surname)->where('patronymic_name', $this->patronymic_name)],
            'email' => 'unique:users'
        ]);
    }
}
