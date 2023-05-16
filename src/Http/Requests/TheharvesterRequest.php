<?php

namespace Ikay\TheharvesterService\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TheharvesterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'container' => 'required|numeric|min:1|lte:10',
            'domain' => 'required|string|regex:/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}(?:\.[a-zA-Z]{2,})?$/',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
