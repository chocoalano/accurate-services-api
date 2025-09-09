<?php

namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest as BaseRequest;

class FormRequest extends BaseRequest
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

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'id' => 'nullable|integer',
            'pic' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'scrapWarehouse' => 'nullable|boolean',
            'street' => 'nullable|string|max:255',
            'suspended' => 'nullable|boolean',
            'zipCode' => 'nullable|string|max:20',
        ];
    }
}
