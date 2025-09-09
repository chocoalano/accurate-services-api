<?php

namespace App\Http\Requests\BillOfMaterial;

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
            'itemNo' => ['required', 'string'],
            'quantity' => ['required', 'numeric', 'min:0', 'max:999000000000.999999'],
            'transDate' => ['required', 'date_format:d/m/Y'],

            'branchId' => ['nullable', 'integer'],
            'branchName' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'itemUnitName' => ['nullable', 'string'],
            'number' => ['nullable', 'string'],
            'secondQualityProductNo' => ['nullable', 'array'],
            'secondQualityProductNo.*' => ['nullable', 'string'],
            'typeAutoNumber' => ['nullable', 'integer'],
            'id' => ['nullable', 'integer'],

            'detailExpense' => ['nullable', 'array'],
            'detailExpense.*.itemNo' => ['required', 'string'],
            'detailExpense.*.quantity' => ['required', 'numeric', 'min:0', 'max:999000000000.999999'],
            'detailExpense.*._status' => ['nullable', 'in:delete'],
            'detailExpense.*.dataClassification1Name' => ['nullable', 'string'],
            'detailExpense.*.dataClassification2Name' => ['nullable', 'string'],
            'detailExpense.*.dataClassification3Name' => ['nullable', 'string'],
            'detailExpense.*.dataClassification4Name' => ['nullable', 'string'],
            'detailExpense.*.dataClassification5Name' => ['nullable', 'string'],
            'detailExpense.*.dataClassification6Name' => ['nullable', 'string'],
            'detailExpense.*.dataClassification7Name' => ['nullable', 'string'],
            'detailExpense.*.dataClassification8Name' => ['nullable', 'string'],
            'detailExpense.*.dataClassification9Name' => ['nullable', 'string'],
            'detailExpense.*.dataClassification10Name' => ['nullable', 'string'],
            'detailExpense.*.departmentName' => ['nullable', 'string'],
            'detailExpense.*.detailName' => ['nullable', 'string'],
            'detailExpense.*.detailNotes' => ['nullable', 'string'],
            'detailExpense.*.id' => ['nullable', 'integer'],
            'detailExpense.*.itemUnitName' => ['nullable', 'string'],
            'detailExpense.*.processCategoryName' => ['nullable', 'string'],
            'detailExpense.*.projectNo' => ['nullable', 'string'],

            'detailMaterial' => ['nullable', 'array'],
            'detailMaterial.*.itemNo' => ['required', 'string'],
            'detailMaterial.*.quantity' => ['required', 'numeric', 'min:0', 'max:999000000000.999999'],
            'detailMaterial.*._status' => ['nullable', 'in:delete'],
            'detailMaterial.*.dataClassification1Name' => ['nullable', 'string'],
            'detailMaterial.*.dataClassification2Name' => ['nullable', 'string'],
            'detailMaterial.*.dataClassification3Name' => ['nullable', 'string'],
            'detailMaterial.*.dataClassification4Name' => ['nullable', 'string'],
            'detailMaterial.*.dataClassification5Name' => ['nullable', 'string'],
            'detailMaterial.*.dataClassification6Name' => ['nullable', 'string'],
            'detailMaterial.*.dataClassification7Name' => ['nullable', 'string'],
            'detailMaterial.*.dataClassification8Name' => ['nullable', 'string'],
            'detailMaterial.*.dataClassification9Name' => ['nullable', 'string'],
            'detailMaterial.*.dataClassification10Name' => ['nullable', 'string'],
            'detailMaterial.*.departmentName' => ['nullable', 'string'],
            'detailMaterial.*.detailName' => ['nullable', 'string'],
            'detailMaterial.*.detailNotes' => ['nullable', 'string'],
            'detailMaterial.*.id' => ['nullable', 'integer'],
            'detailMaterial.*.itemUnitName' => ['nullable', 'string'],
            'detailMaterial.*.processCategoryName' => ['nullable', 'string'],
            'detailMaterial.*.projectNo' => ['nullable', 'string'],

            'detailExtraFinishGood' => ['nullable', 'array'],
            'detailExtraFinishGood.*.itemNo' => ['required', 'string'],
            'detailExtraFinishGood.*.quantity' => ['required', 'numeric', 'min:0', 'max:999000000000.999999'],
            'detailExtraFinishGood.*._status' => ['nullable', 'in:delete'],
            'detailExtraFinishGood.*.dataClassification1Name' => ['nullable', 'string'],
            'detailExtraFinishGood.*.dataClassification2Name' => ['nullable', 'string'],
            'detailExtraFinishGood.*.dataClassification3Name' => ['nullable', 'string'],
            'detailExtraFinishGood.*.dataClassification4Name' => ['nullable', 'string'],
            'detailExtraFinishGood.*.dataClassification5Name' => ['nullable', 'string'],
            'detailExtraFinishGood.*.dataClassification6Name' => ['nullable', 'string'],
            'detailExtraFinishGood.*.dataClassification7Name' => ['nullable', 'string'],
            'detailExtraFinishGood.*.dataClassification8Name' => ['nullable', 'string'],
            'detailExtraFinishGood.*.dataClassification9Name' => ['nullable', 'string'],
            'detailExtraFinishGood.*.dataClassification10Name' => ['nullable', 'string'],
            'detailExtraFinishGood.*.departmentName' => ['nullable', 'string'],
            'detailExtraFinishGood.*.detailName' => ['nullable', 'string'],
            'detailExtraFinishGood.*.detailNotes' => ['nullable', 'string'],
            'detailExtraFinishGood.*.id' => ['nullable', 'integer'],
            'detailExtraFinishGood.*.itemUnitName' => ['nullable', 'string'],
            'detailExtraFinishGood.*.portion' => ['nullable', 'numeric', 'min:0', 'max:999000000000.999999'],
            'detailExtraFinishGood.*.projectNo' => ['nullable', 'string'],

            'detailProcess' => ['nullable', 'array'],
            'detailProcess.*.processCategoryName' => ['required', 'string'],
            'detailProcess.*.sortNumber' => ['required', 'integer'],
            'detailProcess.*._status' => ['nullable', 'in:delete'],
            'detailProcess.*.id' => ['nullable', 'integer'],
            'detailProcess.*.instruction' => ['nullable', 'string'],
            'detailProcess.*.subCon' => ['nullable', 'boolean'],
        ];
    }
}
