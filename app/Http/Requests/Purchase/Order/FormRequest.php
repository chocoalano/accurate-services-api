<?php

namespace App\Http\Requests\Purchase\Order;

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
            // Main Parameters
            'vendorNo' => 'required|string',
            'branchId' => 'nullable|integer',
            'branchName' => 'nullable|string',
            'cashDiscPercent' => 'nullable|string', // Regex bisa ditambahkan jika format persentase spesifik (e.g., /^\d+(\.\d+)?(\s*\+\s*\d+(\.\d+)?)?$/)
            'cashDiscount' => 'nullable|numeric|max:999000000000.999999', // Max 999 miliar dengan 6 desimal
            'currencyCode' => 'nullable|string',
            'description' => 'nullable|string',
            'fillPriceByVendorPrice' => 'nullable|boolean',
            'fobName' => 'nullable|string',
            'id' => 'nullable|integer',
            'inclusiveTax' => 'nullable|boolean',
            'number' => 'nullable|string',
            'paymentTermName' => 'nullable|string',
            'rate' => 'nullable|numeric|max:999000000000.999999', // Max 999 miliar dengan 6 desimal
            'shipDate' => 'nullable|date_format:d/m/Y',
            'shipmentName' => 'nullable|string',
            'taxable' => 'nullable|boolean',
            'toAddress' => 'nullable|string',
            'transDate' => 'nullable|date_format:d/m/Y',
            'typeAutoNumber' => 'nullable|integer',

            // detailExpense[n]
            'detailExpense' => 'nullable|array',
            'detailExpense.*._status' => 'nullable|in:delete', // Contoh nilai enum untuk _status
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

            // detailItem[n]
            'detailItem' => 'nullable|array',
            'detailItem.*.itemNo' => 'required_with:detailItem|string', // Wajib jika detailItem ada
            'detailItem.*.unitPrice' => 'required_with:detailItem|numeric|max:999000000000.999999', // Wajib jika detailItem ada
            'detailItem.*._status' => 'nullable|in:delete',
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
            'detailItem.*.departmentName' => 'nullable|string',
            'detailItem.*.detailName' => 'nullable|string',
            'detailItem.*.detailNotes' => 'nullable|string',
            'detailItem.*.id' => 'nullable|integer',
            'detailItem.*.itemCashDiscount' => 'nullable|numeric|max:999000000000.999999',
            'detailItem.*.itemDiscPercent' => 'nullable|string',
            'detailItem.*.itemUnitName' => 'nullable|string',
            'detailItem.*.projectNo' => 'nullable|string',
            'detailItem.*.purchaseRequisitionNumber' => 'nullable|string',
            'detailItem.*.quantity' => 'nullable|numeric|max:999000000000.999999',
            'detailItem.*.useTax1' => 'nullable|boolean',
            'detailItem.*.useTax2' => 'nullable|boolean',
            'detailItem.*.useTax3' => 'nullable|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'vendorNo.required' => 'Nomor identitas vendor wajib diisi.',
            'detailItem.*.itemNo.required_with' => 'Nomor/Kode barang wajib diisi untuk setiap detail barang.',
            'detailItem.*.unitPrice.required_with' => 'Harga jual barang/jasa wajib diisi untuk setiap detail barang.',
            '*.numeric' => 'Kolom :attribute harus berupa angka.',
            '*.integer' => 'Kolom :attribute harus berupa angka non-desimal.',
            '*.string' => 'Kolom :attribute harus berupa teks.',
            '*.boolean' => 'Kolom :attribute harus berupa true atau false.',
            '*.date_format' => 'Kolom :attribute harus dalam format tanggal DD/MM/YYYY.',
            '*.max' => 'Nilai :attribute melebihi batas maksimum yang diizinkan.',
            '*.in' => 'Nilai :attribute tidak valid.',
        ];
    }
}
