<?php

namespace App\Http\Requests\PublishingHouse;

use App\Http\Requests\AbstractApiRequest;

class PublishingHouseUpdateDto extends AbstractApiRequest
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
            'address' => ['required']
        ];
    }
}
