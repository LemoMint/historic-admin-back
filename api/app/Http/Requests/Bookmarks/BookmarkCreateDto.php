<?php

namespace App\Http\Requests\Bookmarks;

use Illuminate\Validation\Rule;
use App\Http\Requests\AbstractApiRequest;

class BookmarkCreateDto extends AbstractApiRequest
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
            'page' => ['required', 'integer', Rule::unique('bookmarks')->where('document_id', $this->document_id)],
            'document_id' => ['required', 'exists:documents,id']
        ];
    }
}
