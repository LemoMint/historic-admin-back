<?php


namespace App\Http\Requests\Publication;

use Illuminate\Validation\Rules\File;

class PublicationCreateDto extends PublicationUpdateDto
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
        return array_merge_recursive(parent::rules(), [
            'name' => 'unique:publications',
            'description' => 'unique:publications',
        ]);
    }
}
