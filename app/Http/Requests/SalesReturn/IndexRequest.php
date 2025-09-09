<?php

namespace App\Http\Requests\SalesReturn;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Ambil semua input query + header supaya validasi bisa berjalan pada GET request.
     */
    public function validationData(): array
    {
        return array_merge($this->all(), $this->headers->all());
    }

    /**
     * Aturan validasi input.
     */
    public function rules(): array
    {
        return [
            // Pagination and Sorting
            'page' => ['required', 'integer', 'min:1'],
            'pageSize' => ['required', 'integer', 'min:1'],
        ];
    }
}
