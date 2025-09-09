<?php

namespace App\Http\Requests\FinishGood;

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
            'branchId' => ['required', 'integer'],
            'transDate' => ['required', 'date_format:d/m/Y'],
            'workOrderNumber' => ['required', 'string'],

            'detailItem' => ['required', 'array', 'min:1'],
            'detailItem.*.itemNo' => ['required', 'string'],
            'detailItem.*.portion' => ['required', 'numeric', 'max:999000000000', 'regex:/^\d+(\.\d{1,6})?$/'],
            'detailItem.*.quantity' => ['required', 'numeric', 'max:999000000000', 'regex:/^\d+(\.\d{1,6})?$/'],
            'detailItem.*.warehouseId' => ['required', 'integer'],
            'detailItem.*._status' => ['nullable', 'in:delete'],

            'detailItem.*.dataClassification1Name' => ['nullable', 'string'],
            'detailItem.*.dataClassification2Name' => ['nullable', 'string'],
            'detailItem.*.dataClassification3Name' => ['nullable', 'string'],
            'detailItem.*.dataClassification4Name' => ['nullable', 'string'],
            'detailItem.*.dataClassification5Name' => ['nullable', 'string'],
            'detailItem.*.dataClassification6Name' => ['nullable', 'string'],
            'detailItem.*.dataClassification7Name' => ['nullable', 'string'],
            'detailItem.*.dataClassification8Name' => ['nullable', 'string'],
            'detailItem.*.dataClassification9Name' => ['nullable', 'string'],
            'detailItem.*.dataClassification10Name' => ['nullable', 'string'],

            'detailItem.*.departmentName' => ['nullable', 'string'],
            'detailItem.*.detailName' => ['nullable', 'string'],
            'detailItem.*.detailNotes' => ['nullable', 'string'],
            'detailItem.*.itemUnitName' => ['nullable', 'string'],
            'detailItem.*.projectNo' => ['nullable', 'string'],
            'detailItem.*.warehouseName' => ['nullable', 'string'],
            'detailItem.*.id' => ['nullable', 'integer'],

            'detailItem.*.detailSerialNumber' => ['nullable', 'array'],
            'detailItem.*.detailSerialNumber.*._status' => ['nullable', 'in:delete'],
            'detailItem.*.detailSerialNumber.*.expiredDate' => ['nullable', 'date_format:d/m/Y'],
            'detailItem.*.detailSerialNumber.*.id' => ['nullable', 'integer'],
            'detailItem.*.detailSerialNumber.*.quantity' => ['nullable', 'numeric', 'max:999000000000', 'regex:/^\d+(\.\d{1,6})?$/'],
            'detailItem.*.detailSerialNumber.*.serialNumberNo' => ['nullable', 'string'],

            'branchName' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'id' => ['nullable', 'integer'],
            'number' => ['nullable', 'string'],
            'typeAutoNumber' => ['nullable', 'integer'],
        ];
    }
}
