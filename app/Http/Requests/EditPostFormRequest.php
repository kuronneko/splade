<?php

namespace App\Http\Requests;

use App\Forms\CreatePostForm;
use App\Forms\EditPostForm;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Http\FormRequest;

class EditPostFormRequest extends FormRequest
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
            'published_at' => 'required',
            'name' => 'required|max:255',
            'category_id' => 'required',
            'tags' => 'required|array',
            'tags.*' => 'required',
            'image' => 'nullable|required',
            'content' => 'required|max:255',
        ];
    }
}
