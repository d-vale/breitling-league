<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'sub_title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'reading_status' => 'required|string|in:to-read,read,pending',
            'resume' => 'required|string|max:2000',
            'format' => 'required|string|max:100',
            'number_of_pages' => 'required|integer|min:1',
            'release_date' => 'required|date',
            'editor' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|regex:/^[0-9-]+$/',
            'cover_image_path' => 'required|url',
        ];
    }
}
    