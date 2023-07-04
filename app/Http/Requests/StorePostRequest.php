<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:posts|max:255',
            'url' => 'required|unique:posts|max:255|url',
            'description' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $url = $this->input('url');

            if (!$this->isValidUrl($url)) {
                $validator->errors()->add('url', 'The URL must be a valid and safe URL.');
            }
        });
    }

    private function isValidUrl($url)
    {
        $allowedSchemes = ['http', 'https'];
        $parsedUrl = parse_url($url);

        return isset($parsedUrl['scheme']) && in_array($parsedUrl['scheme'], $allowedSchemes);
    }
}
