<?php

namespace App\Http\Requests\SalesReturn;

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
            'customerNo' => 'required|string|max:255',
            'returnType' => [
                'required',
                'string',
                Rule::in([
                    'DELIVERY',
                    'INVOICE',
                    'INVOICE_DP',
                    'NO_INVOICE',
                ])
            ], // Contoh nilai yang dapat digunakan
            'taxDate' => 'required|date_format:d/m/Y', // Format tanggal DD/MM/YYYY
            'taxNumber' => 'required|string|max:255',

            // Field Opsional Utama
            'branchId' => 'nullable|integer',
            'branchName' => 'nullable|string|max:255',
            'cashDiscPercent' => 'nullable|string|max:255', // Contoh: "5 + 2"
            'cashDiscount' => 'nullable|numeric|between:0,999000000000.999999', // Maks 999 miliar dengan 6 desimal
            'currencyCode' => 'nullable|string|max:255',
            'deliveryOrderNumber' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'fiscalRate' => 'nullable|numeric|between:0,999000000000.999999',
            'fobName' => 'nullable|string|max:255',
            'id' => 'nullable|integer',
            'inclusiveTax' => 'nullable|boolean',
            'invoiceNumber' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:255',
            'paymentTermName' => 'nullable|string|max:255',
            'rate' => 'nullable|numeric|between:0,999000000000.999999',
            'returnStatusType' => ['nullable', 'string', Rule::in(['RETURNED', 'PARTIALLY_RETURNED', 'NOT_RETURNED'])], // Contoh nilai yang dapat digunakan
            'shipmentName' => 'nullable|string|max:255',
            'taxable' => 'nullable|boolean',
            'toAddress' => 'nullable|string|max:255',
            'transDate' => 'nullable|date_format:d/m/Y',
            'typeAutoNumber' => 'nullable|integer',

            // Validasi untuk detailExpense (array of objects)
            'detailExpense' => 'nullable|array',
            'detailExpense.*._status' => ['nullable', 'string', Rule::in(['delete'])],
            'detailExpense.*.accountNo' => 'nullable|string|max:255',
            'detailExpense.*.dataClassification10Name' => 'nullable|string|max:255',
            'detailExpense.*.dataClassification1Name' => 'nullable|string|max:255',
            'detailExpense.*.dataClassification2Name' => 'nullable|string|max:255',
            'detailExpense.*.dataClassification3Name' => 'nullable|string|max:255',
            'detailExpense.*.dataClassification4Name' => 'nullable|string|max:255',
            'detailExpense.*.dataClassification5Name' => 'nullable|string|max:255',
            'detailExpense.*.dataClassification6Name' => 'nullable|string|max:255',
            'detailExpense.*.dataClassification7Name' => 'nullable|string|max:255',
            'detailExpense.*.dataClassification8Name' => 'nullable|string|max:255',
            'detailExpense.*.dataClassification9Name' => 'nullable|string|max:255',
            'detailExpense.*.departmentName' => 'nullable|string|max:255',
            'detailExpense.*.expenseAmount' => 'nullable|numeric|between:0,999000000000.999999',
            'detailExpense.*.expenseName' => 'nullable|string|max:255',
            'detailExpense.*.expenseNotes' => 'nullable|string|max:255',
            'detailExpense.*.id' => 'nullable|integer',
            'detailExpense.*.salesOrderNumber' => 'nullable|string|max:255',
            'detailExpense.*.salesQuotationNumber' => 'nullable|string|max:255',

            // Validasi untuk detailItem (array of objects)
            'detailItem' => 'nullable|array',
            'detailItem.*.itemNo' => 'required|string|max:255',
            'detailItem.*.unitPrice' => 'required|numeric|between:0,999000000000.999999',
            'detailItem.*._status' => ['nullable', 'string', Rule::in(['delete'])],
            'detailItem.*.dataClassification10Name' => 'nullable|string|max:255',
            'detailItem.*.dataClassification1Name' => 'nullable|string|max:255',
            'detailItem.*.dataClassification2Name' => 'nullable|string|max:255',
            'detailItem.*.dataClassification3Name' => 'nullable|string|max:255',
            'detailItem.*.dataClassification4Name' => 'nullable|string|max:255',
            'detailItem.*.dataClassification5Name' => 'nullable|string|max:255',
            'detailItem.*.dataClassification6Name' => 'nullable|string|max:255',
            'detailItem.*.dataClassification7Name' => 'nullable|string|max:255',
            'detailItem.*.dataClassification8Name' => 'nullable|string|max:255',
            'detailItem.*.dataClassification9Name' => 'nullable|string|max:255',
            'detailItem.*.departmentName' => 'nullable|string|max:255',
            'detailItem.*.detailName' => 'nullable|string|max:255',
            'detailItem.*.detailNotes' => 'nullable|string|max:255',
            'detailItem.*.id' => 'nullable|integer',
            'detailItem.*.itemCashDiscount' => 'nullable|numeric|between:0,999000000000.999999',
            'detailItem.*.itemDiscPercent' => 'nullable|string|max:255',
            'detailItem.*.itemUnitName' => 'nullable|string|max:255',
            'detailItem.*.projectNo' => 'nullable|string|max:255',
            'detailItem.*.quantity' => 'nullable|numeric|between:0,999000000000.999999',
            'detailItem.*.returnDetailStatusType' => ['nullable', 'string', Rule::in(['NOT_RETURNED', 'RETURNED'])], // Contoh nilai yang dapat digunakan
            'detailItem.*.useTax1' => 'nullable|boolean',
            'detailItem.*.useTax2' => 'nullable|boolean',
            'detailItem.*.useTax3' => 'nullable|boolean',
            'detailItem.*.warehouseName' => 'nullable|string|max:255',

            // Validasi untuk detailSerialNumber (nested array of objects)
            'detailItem.*.detailSerialNumber' => 'nullable|array',
            'detailItem.*.detailSerialNumber.*._status' => ['nullable', 'string', Rule::in(['delete'])],
            'detailItem.*.detailSerialNumber.*.expiredDate' => 'nullable|date_format:d/m/Y',
            'detailItem.*.detailSerialNumber.*.id' => 'nullable|integer',
            'detailItem.*.detailSerialNumber.*.quantity' => 'nullable|numeric|between:0,999000000000.999999',
            'detailItem.*.detailSerialNumber.*.serialNumberNo' => 'nullable|string|max:255',
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
            'customerNo.required' => 'Nomor identitas pelanggan wajib diisi.',
            'customerNo.string' => 'Nomor identitas pelanggan harus berupa teks.',
            'customerNo.max' => 'Nomor identitas pelanggan tidak boleh lebih dari :max karakter.',

            'returnType.required' => 'Tipe retur wajib diisi.',
            'returnType.in' => 'Tipe retur tidak valid.',

            'taxDate.required' => 'Tanggal pencatatan pajak wajib diisi.',
            'taxDate.date_format' => 'Format tanggal pajak harus DD/MM/YYYY.',

            'taxNumber.required' => 'Nomor faktur pajak wajib diisi.',
            'taxNumber.string' => 'Nomor faktur pajak harus berupa teks.',
            'taxNumber.max' => 'Nomor faktur pajak tidak boleh lebih dari :max karakter.',

            // Pesan untuk detailExpense
            'detailExpense.*.expenseAmount.numeric' => 'Jumlah nilai pengeluaran harus berupa angka.',
            'detailExpense.*.expenseAmount.between' => 'Jumlah nilai pengeluaran harus antara 0 hingga 999 miliar dengan 6 digit desimal.',

            // Pesan untuk detailItem
            'detailItem.*.itemNo.required' => 'Nomor/Kode barang wajib diisi untuk setiap detail item.',
            'detailItem.*.unitPrice.required' => 'Harga jual barang/jasa wajib diisi untuk setiap detail item.',
            'detailItem.*.unitPrice.numeric' => 'Harga jual barang/jasa harus berupa angka.',
            'detailItem.*.unitPrice.between' => 'Harga jual barang/jasa harus antara 0 hingga 999 miliar dengan 6 digit desimal.',
            'detailItem.*.quantity.numeric' => 'Jumlah barang/jasa harus berupa angka.',
            'detailItem.*.quantity.between' => 'Jumlah barang/jasa harus antara 0 hingga 999 miliar dengan 6 digit desimal.',
            'detailItem.*.itemCashDiscount.numeric' => 'Diskon barang/jasa harus berupa angka.',
            'detailItem.*.itemCashDiscount.between' => 'Diskon barang/jasa harus antara 0 hingga 999 miliar dengan 6 digit desimal.',

            // Pesan untuk detailSerialNumber
            'detailItem.*.detailSerialNumber.*.expiredDate.date_format' => 'Format tanggal expire untuk Nomor Produksi harus DD/MM/YYYY.',
            'detailItem.*.detailSerialNumber.*.quantity.numeric' => 'Jumlah barang untuk Nomor Produksi harus berupa angka.',
            'detailItem.*.detailSerialNumber.*.quantity.between' => 'Jumlah barang untuk Nomor Produksi harus antara 0 hingga 999 miliar dengan 6 digit desimal.',

            // Tambahkan pesan kustom lainnya sesuai kebutuhan
        ];
    }
}
