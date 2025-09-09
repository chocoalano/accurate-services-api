<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest as BaseRequest;
use Illuminate\Validation\Rule;

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
            // Field Wajib
            'name' => 'required|string|max:255',

            // Field Opsional
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'id' => 'nullable|integer', // 'id' perlu diisi hanya jika melakukan perubahan/penghapusan data yang sudah ada
            'province' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'zipCode' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama Cabang wajib diisi.',
            'name.string' => 'Nama Cabang harus berupa teks.',
            'name.max' => 'Nama Cabang tidak boleh lebih dari :max karakter.',

            'city.string' => 'Kota harus berupa teks.',
            'city.max' => 'Kota tidak boleh lebih dari :max karakter.',

            'country.string' => 'Negara harus berupa teks.',
            'country.max' => 'Negara tidak boleh lebih dari :max karakter.',

            'id.integer' => 'ID harus berupa angka non-desimal.',

            'province.string' => 'Provinsi harus berupa teks.',
            'province.max' => 'Provinsi tidak boleh lebih dari :max karakter.',

            'street.string' => 'Jalan harus berupa teks.',
            'street.max' => 'Jalan tidak boleh lebih dari :max karakter.',

            'zipCode.string' => 'K.Pos harus berupa teks.',
            'zipCode.max' => 'K.Pos tidak boleh lebih dari :max karakter.',
        ];
    }
}
