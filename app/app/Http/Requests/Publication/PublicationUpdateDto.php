<?php


namespace App\Http\Requests\Publication;

use Illuminate\Validation\Rules\File;
use App\Http\Requests\AbstractApiRequest;

class PublicationUpdateDto extends AbstractApiRequest
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
            'description' => ['required'],
            'publication_year' => ['nullable', 'numeric','min:1','max:2100'],
            'publication_century' => ['nullable', 'numeric','min:1', 'max:22'],
            'publishing_house_id' => ['nullable', 'integer', 'exists:publishing_houses,id'],
            'document' => ['required', File::types(['mp3', 'mp4', 'pdf', 'jpg', 'jpeg', 'png'])],
            'authors' => ['array'],
            'authors.*' => ['exists:authors,id'],
            // 'categories' => ['nullable'],
        ];
    }
}
