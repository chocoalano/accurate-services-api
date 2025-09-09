<?php

namespace App\Http\Requests\SalesOrder;

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
            'customerNo' => ['required', 'string', 'max:255'],

            // detailExpense Validasi Array
            'detailExpense' => ['nullable', 'array'],
            'detailExpense.*._status' => ['nullable', Rule::in(['delete'])],
            'detailExpense.*.accountNo' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.dataClassification10Name' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.dataClassification1Name' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.dataClassification2Name' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.dataClassification3Name' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.dataClassification4Name' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.dataClassification5Name' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.dataClassification6Name' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.dataClassification7Name' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.dataClassification8Name' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.dataClassification9Name' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.departmentName' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.expenseAmount' => ['nullable', 'numeric', 'between:0,999000000000'], // 999 miliar
            'detailExpense.*.expenseName' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.expenseNotes' => ['nullable', 'string', 'max:255'],
            'detailExpense.*.id' => ['nullable', 'integer'],
            'detailExpense.*.salesQuotationNumber' => ['nullable', 'string', 'max:255'],

            // detailItem Validasi Array
            'detailItem' => ['required', 'array'],
            'detailItem.*.itemNo' => ['required', 'string', 'max:255'],
            'detailItem.*.unitPrice' => ['required', 'numeric', 'between:0,999000000000'],
            'detailItem.*._status' => ['nullable', Rule::in(['delete'])],
            'detailItem.*.dataClassification10Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification1Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification2Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification3Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification4Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification5Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification6Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification7Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification8Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.dataClassification9Name' => ['nullable', 'string', 'max:255'],
            'detailItem.*.departmentName' => ['nullable', 'string', 'max:255'],
            'detailItem.*.detailName' => ['nullable', 'string', 'max:255'],
            'detailItem.*.detailNotes' => ['nullable', 'string', 'max:255'],
            'detailItem.*.id' => ['nullable', 'integer'],
            'detailItem.*.itemCashDiscount' => ['nullable', 'numeric', 'between:0,999000000000'],
            'detailItem.*.itemDiscPercent' => ['nullable', 'string', 'max:255'], // format persen string seperti "5+2"
            'detailItem.*.itemUnitName' => ['nullable', 'string', 'max:255'],
            'detailItem.*.projectNo' => ['nullable', 'string', 'max:255'],
            'detailItem.*.quantity' => ['nullable', 'numeric', 'between:0,999000000000'],
            'detailItem.*.salesQuotationNumber' => ['nullable', 'string', 'max:255'],
            'detailItem.*.salesmanListNumber' => ['nullable', 'array'],
            'detailItem.*.salesmanListNumber.*' => ['nullable', 'string', 'max:255'],
            'detailItem.*.useTax1' => ['nullable', 'boolean'],
            'detailItem.*.useTax2' => ['nullable', 'boolean'],
            'detailItem.*.useTax3' => ['nullable', 'boolean'],

            // Data tambahan transaksi
            'branchId' => ['nullable', 'integer'],
            'branchName' => ['nullable', 'string', 'max:255'],
            'cashDiscPercent' => ['nullable', 'string', 'max:255'],
            'cashDiscount' => ['nullable', 'numeric', 'between:0,999000000000'],
            'currencyCode' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string', 'max:255'],
            'fobName' => ['nullable', 'string', 'max:255'],
            'id' => ['nullable', 'integer'],
            'inclusiveTax' => ['nullable', 'boolean'],
            'number' => ['nullable', 'string', 'max:255'],
            'paymentTermName' => ['nullable', 'string', 'max:255'],
            'poNumber' => ['nullable', 'string', 'max:255'],
            'rate' => ['nullable', 'numeric', 'between:0,999000000000'],
            'shipDate' => ['nullable', 'date_format:d/m/Y'],
            'shipmentName' => ['nullable', 'string', 'max:255'],
            'taxable' => ['nullable', 'boolean'],
            'toAddress' => ['nullable', 'string', 'max:255'],
            'transDate' => ['nullable', 'date_format:d/m/Y'],
            'typeAutoNumber' => ['nullable', 'integer'],
        ];
    }
}
