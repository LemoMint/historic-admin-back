<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use App\Http\Requests\AbstractApiRequest;

class UpdateProfileDto extends AbstractApiRequest
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
            'name' => ['required'],
            'surname' => ['required'],
            'patronymic_name' => [''],
            'email' => ['required'],
            'avatar' => ['nullable']
        ];
    }
}
