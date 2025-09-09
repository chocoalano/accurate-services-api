<?php

namespace App\Http\Requests\Delivery;

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
            'customerNo' => ['required', 'string', 'max:255'],
            'branchId' => ['nullable', 'integer'],
            'branchName' => ['nullable', 'string', 'max:255'],
            'cashDiscPercent' => ['nullable', 'string', 'max:255'],
            'cashDiscount' => ['nullable', 'numeric', 'between:0,999000000000'],
            'currencyCode' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'fobName' => ['nullable', 'string', 'max:255'],
            'id' => ['nullable', 'integer'],
            'inclusiveTax' => ['nullable', 'boolean'],
            'number' => ['nullable', 'string', 'max:255'],
            'paymentTermName' => ['nullable', 'string', 'max:255'],
            'poNumber' => ['nullable', 'string', 'max:255'],
            'rate' => ['nullable', 'numeric', 'between:0,999000000000'],
            'shipmentName' => ['nullable', 'string', 'max:255'],
            'taxable' => ['nullable', 'boolean'],
            'toAddress' => ['nullable', 'string', 'max:255'],
            'transDate' => ['nullable', 'date_format:d/m/Y'],
            'typeAutoNumber' => ['nullable', 'integer'],

            'detailItem' => ['required', 'array', 'min:1'],
            'detailItem.*.itemNo' => ['required', 'string', 'max:255'],
            'detailItem.*.unitPrice' => ['required', 'numeric', 'between:0,999000000000'],
            'detailItem.*._status' => ['nullable', 'in:delete'],
            'detailItem.*.controlQuantity' => ['nullable', 'numeric', 'between:0,999000000000'],

            'detailItem.*.dataClassification1Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification2Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification3Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification4Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification5Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification6Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification7Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification8Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification9Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification10Name' => ['nullable', 'string', 'max:255'],

            'detailItem.*.departmentName' => ['nullable', 'string', 'max:255'],
            'detailItem.*.detailName' => ['nullable', 'string', 'max:255'],
            'detailItem.*.detailNotes' => ['nullable', 'string', 'max:255'],

            'detailItem.*.id' => ['nullable', 'integer'],
            'detailItem.*.itemCashDiscount' => ['nullable', 'numeric', 'between:0,999000000000'],
            'detailItem.*.itemDiscPercent' => ['nullable', 'string', 'max:255'],
            'detailItem.*.itemUnitName' => ['nullable', 'string', 'max:255'],
            'detailItem.*.projectNo' => ['nullable', 'string', 'max:255'],
            'detailItem.*.quantity' => ['nullable', 'numeric', 'between:0,999000000000'],
            'detailItem.*.reverseInvoiceNumber' => ['nullable', 'string', 'max:255'],
            'detailItem.*.salesOrderNumber' => ['nullable', 'string', 'max:255'],
            'detailItem.*.salesQuotationNumber' => ['nullable', 'string', 'max:255'],

            'detailItem.*.salesmanListNumber' => ['nullable', 'array'],
            'detailItem.*.salesmanListNumber.*' => ['nullable', 'string', 'max:255'],

            'detailItem.*.useTax1' => ['nullable', 'boolean'],
            'detailItem.*.useTax2' => ['nullable', 'boolean'],
            'detailItem.*.useTax3' => ['nullable', 'boolean'],
            'detailItem.*.warehouseName' => ['nullable', 'string', 'max:255'],

            'detailItem.*.detailSerialNumber' => ['nullable', 'array'],
            'detailItem.*.detailSerialNumber.*._status' => ['nullable', 'in:delete'],
            'detailItem.*.detailSerialNumber.*.expiredDate' => ['nullable', 'date_format:d/m/Y'],
            'detailItem.*.detailSerialNumber.*.id' => ['nullable', 'integer'],
            'detailItem.*.detailSerialNumber.*.quantity' => ['nullable', 'numeric', 'between:0,999000000000'],
            'detailItem.*.detailSerialNumber.*.serialNumberNo' => ['nullable', 'string', 'max:255'],
        ];
    }
}
