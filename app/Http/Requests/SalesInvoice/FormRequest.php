<?php

namespace App\Http\Requests\SalesInvoice;

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
            'customerNo' => 'required|string',
            'branchId' => 'nullable|integer',
            'branchName' => 'nullable|string',
            'cashDiscPercent' => 'nullable|string',
            'cashDiscount' => 'nullable|numeric|max:999000000000.999999',
            'currencyCode' => 'nullable|string',
            'description' => 'nullable|string',
            'documentCode' => 'nullable|in:CTAS_DELIVERY,CTAS_EXPORT,CTAS_EXPORT,CTAS_INVOICE,DIGUNGGUNG', // Replace with actual enum values
            'documentTransaction' => 'nullable|in:CTAS_CUKAI_ROKO,CTAS_DIPERSAMAKAN,CTAS_EKSPOR_BARANG,CTAS_EKSPOR_DOKUMEN, CTAS_PEMBERITAHUAN_EKSPOR_TIDAK_BERWUJUD', // Replace with actual enum values
            'fiscalRate' => 'nullable|numeric|max:999000000000.999999',
            'fobName' => 'nullable|string',
            'id' => 'nullable|integer',
            'inclusiveTax' => 'nullable|boolean',
            'inputDownPayment' => 'nullable|numeric|max:999000000000.999999',
            'invoiceDp' => 'nullable|boolean',
            'number' => 'nullable|string',
            'orderDownPaymentNumber' => 'nullable|string',
            'paymentTermName' => 'nullable|string',
            'poNumber' => 'nullable|string',
            'rate' => 'nullable|numeric|max:999000000000.999999',
            'retailIdCard' => 'nullable|string',
            'retailWpName' => 'nullable|string',
            'reverseInvoice' => 'nullable|boolean',
            'shipDate' => 'nullable|date_format:d/m/Y',
            'shipmentName' => 'nullable|string',
            'tax1Name' => 'nullable|string',
            'taxDate' => 'nullable|date_format:d/m/Y',
            'taxNumber' => 'nullable|string',
            'taxType' => 'nullable|in:DUMMY_CUSTOMER_TAX_TYPE_VALUE_1,DUMMY_CUSTOMER_TAX_TYPE_VALUE_2', // Replace with actual enum values
            'taxable' => 'nullable|boolean',
            'toAddress' => 'nullable|string',
            'transDate' => 'nullable|date_format:d/m/Y',
            'typeAutoNumber' => 'nullable|integer',

            // detailDownPayment[*]
            'detailDownPayment' => 'nullable|array',
            'detailDownPayment.*._status' => 'nullable|in:delete',
            'detailDownPayment.*.id' => 'nullable|integer',
            'detailDownPayment.*.invoiceNumber' => 'nullable|string',
            'detailDownPayment.*.paymentAmount' => 'nullable|numeric|max:999000000000.999999',

            // detailExpense[*]
            'detailExpense' => 'nullable|array',
            'detailExpense.*._status' => 'nullable|in:delete',
            'detailExpense.*.accountNo' => 'nullable|string',
            'detailExpense.*.dataClassification10Name' => 'nullable|string',
            'detailExpense.*.dataClassification1Name' => 'nullable|string',
            'detailExpense.*.dataClassification2Name' => 'nullable|string',
            'detailExpense.*.dataClassification3Name' => 'nullable|string',
            'detailExpense.*.dataClassification4Name' => 'nullable|string',
            'detailExpense.*.dataClassification5Name' => 'nullable|string',
            'detailExpense.*.dataClassification6Name' => 'nullable|string',
            'detailExpense.*.dataClassification7Name' => 'nullable|string',
            'detailExpense.*.dataClassification8Name' => 'nullable|string',
            'detailExpense.*.dataClassification9Name' => 'nullable|string',
            'detailExpense.*.departmentName' => 'nullable|string',
            'detailExpense.*.expenseAmount' => 'nullable|numeric|max:999000000000.999999',
            'detailExpense.*.expenseName' => 'nullable|string',
            'detailExpense.*.expenseNotes' => 'nullable|string',
            'detailExpense.*.id' => 'nullable|integer',
            'detailExpense.*.salesOrderNumber' => 'nullable|string',
            'detailExpense.*.salesQuotationNumber' => 'nullable|string',

            // detailItem[*]
            'detailItem' => 'nullable|array',
            'detailItem.*.itemNo' => 'required_with:detailItem|string', // Required if detailItem is present
            'detailItem.*.unitPrice' => 'required_with:detailItem|numeric|max:999000000000.999999', // Required if detailItem is present
            'detailItem.*._status' => 'nullable|in:delete',
            'detailItem.*.controlQuantity' => 'nullable|numeric|max:999000000000.999999',
            'detailItem.*.dataClassification10Name' => 'nullable|string',
            'detailItem.*.dataClassification1Name' => 'nullable|string',
            'detailItem.*.dataClassification2Name' => 'nullable|string',
            'detailItem.*.dataClassification3Name' => 'nullable|string',
            'detailItem.*.dataClassification4Name' => 'nullable|string',
            'detailItem.*.dataClassification5Name' => 'nullable|string',
            'detailItem.*.dataClassification6Name' => 'nullable|string',
            'detailItem.*.dataClassification7Name' => 'nullable|string',
            'detailItem.*.dataClassification8Name' => 'nullable|string',
            'detailItem.*.dataClassification9Name' => 'nullable|string',
            'detailItem.*.deliveryOrderNumber' => 'nullable|string',
            'detailItem.*.departmentName' => 'nullable|string',
            'detailItem.*.detailName' => 'nullable|string',
            'detailItem.*.detailNotes' => 'nullable|string',
            'detailItem.*.id' => 'nullable|integer',
            'detailItem.*.itemCashDiscount' => 'nullable|numeric|max:999000000000.999999',
            'detailItem.*.itemDiscPercent' => 'nullable|string',
            'detailItem.*.itemUnitName' => 'nullable|string',
            'detailItem.*.projectNo' => 'nullable|string',
            'detailItem.*.quantity' => 'nullable|numeric|max:999000000000.999999',
            'detailItem.*.salesOrderNumber' => 'nullable|string',
            'detailItem.*.salesQuotationNumber' => 'nullable|string',
            'detailItem.*.salesmanListNumber' => 'nullable|array',
            'detailItem.*.salesmanListNumber.*' => 'nullable|string', // Each element in the array
            'detailItem.*.useTax1' => 'nullable|boolean',
            'detailItem.*.useTax2' => 'nullable|boolean',
            'detailItem.*.useTax3' => 'nullable|boolean',
            'detailItem.*.warehouseName' => 'nullable|string',

            // detailItem[*].detailSerialNumber[*]
            'detailItem.*.detailSerialNumber' => 'nullable|array',
            'detailItem.*.detailSerialNumber.*._status' => 'nullable|in:delete',
            'detailItem.*.detailSerialNumber.*.expiredDate' => 'nullable|date_format:d/m/Y',
            'detailItem.*.detailSerialNumber.*.id' => 'nullable|integer',
            'detailItem.*.detailSerialNumber.*.quantity' => 'nullable|numeric|max:999000000000.999999',
            'detailItem.*.detailSerialNumber.*.serialNumberNo' => 'nullable|string',
        ];
    }
}
