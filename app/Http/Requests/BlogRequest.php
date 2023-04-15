<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "title" => "required|string",
            "slug" => "nullable|string",
            "photo" => "nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048",
            "meta_description" => "require|string",
            "meta_keywords" => "nullable|string",
            "tags" => "nullable|string",
            "cover_image" => "nullable",
            "body" => "required|min:500|string",
            "category_id" => "nullable",
            "status" => "boolean",
        ];
    }
    public function withValidator($validator)
{
    $validator->sometimes('premium', 'nullable|boolean', function () {
        return $this->user()->hasAnyRole(['admin', 'super-admin']);
    });
}
//     public function withValidator($validator)
// {
//     $validator->sometimes('salary', 'nullable|boolean', function ($input) {
//         return $input->salary <= 60;
//     });
// }
}
