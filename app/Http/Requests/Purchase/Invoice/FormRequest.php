<?php

namespace App\Http\Requests\Purchase\Invoice;

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
            'billNumber' => 'nullable|string',
            'branchId' => 'nullable|integer',
            'branchName' => 'nullable|string',
            'cashDiscPercent' => 'nullable|string', // Regex bisa ditambahkan jika format persentase spesifik (e.g., /^\d+(\.\d+)?(\s*\+\s*\d+(\.\d+)?)?$/)
            'cashDiscount' => 'nullable|numeric|max:999000000000.999999',
            'currencyCode' => 'nullable|string',
            'description' => 'nullable|string',
            'documentCode' => 'nullable|in:CTAS_IMPORT,CTAS_INVOICE,CTAS_PURCHASE,CTAS_UNCREDIT,DIGUNGGUNG', // Ganti dengan nilai aktual
            'documentTransaction' => 'nullable|in:CTAS_DOKUMEN_KHUSUS,CTAS_PEMBAYARAN,CTAS_PEMBERITAHUAN_IMPORT,CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN,CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH', // Ganti dengan nilai aktual
            'fillPriceByVendorPrice' => 'nullable|boolean',
            'fiscalRate' => 'nullable|numeric|max:999000000000.999999',
            'fobName' => 'nullable|string',
            'id' => 'nullable|integer',
            'inclusiveTax' => 'nullable|boolean',
            'inputDownPayment' => 'nullable|numeric|max:999000000000.999999',
            'invoiceDp' => 'nullable|boolean',
            'number' => 'nullable|string',
            'orderDownPaymentNumber' => 'nullable|string',
            'paymentTermName' => 'nullable|string',
            'rate' => 'nullable|numeric|max:999000000000.999999',
            'reverseInvoice' => 'nullable|boolean',
            'shipDate' => 'nullable|date_format:d/m/Y',
            'shipmentName' => 'nullable|string',
            'tax1Name' => 'nullable|string',
            'taxDate' => 'nullable|date_format:d/m/Y',
            'taxNumber' => 'nullable|string',
            'taxable' => 'nullable|boolean',
            'toAddress' => 'nullable|string',
            'transDate' => 'nullable|date_format:d/m/Y',
            'typeAutoNumber' => 'nullable|integer',
            'vendorTaxType' => 'nullable|in:CTAS_BESARAN_TERTENTU,CTAS_DPP_NILAI_LAIN,CTAS_IMPOR_BARANG_KENA_PAJAK,CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI,CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH,CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH,CTAS_KEPADA_SELAIN_PEMUNGUT_PPN,CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK,CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN,CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN,CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT,CTAS_PENYERAHAN_LAINNYA', // Ganti dengan nilai aktual

            // detailDownPayment[n]
            'detailDownPayment' => 'nullable|array',
            'detailDownPayment.*._status' => 'nullable|in:delete',
            'detailDownPayment.*.id' => 'nullable|integer',
            'detailDownPayment.*.invoiceNumber' => 'nullable|string',
            'detailDownPayment.*.paymentAmount' => 'nullable|numeric|max:999000000000.999999',

            // detailExpense[n]
            'detailExpense' => 'nullable|array',
            'detailExpense.*._status' => 'nullable|in:delete',
            'detailExpense.*.accountNo' => 'nullable|string',
            'detailExpense.*.allocateToItemCost' => 'nullable|boolean',
            'detailExpense.*.amountCurrency' => 'nullable|numeric|max:999000000000.999999',
            'detailExpense.*.chargedVendorName' => 'nullable|string',
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
            'detailExpense.*.expenseCurrencyCode' => 'nullable|string',
            'detailExpense.*.expenseName' => 'nullable|string',
            'detailExpense.*.expenseNotes' => 'nullable|string',
            'detailExpense.*.id' => 'nullable|integer',
            'detailExpense.*.purchaseOrderNumber' => 'nullable|string',

            // detailItem[n]
            'detailItem' => 'nullable|array',
            'detailItem.*.itemNo' => 'required_with:detailItem|string',
            'detailItem.*.unitPrice' => 'required_with:detailItem|numeric|max:999000000000.999999',
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
            'detailItem.*.purchaseOrderNumber' => 'nullable|string',
            'detailItem.*.purchaseRequisitionNumber' => 'nullable|string', // Priority: receiveItemNumber, purchaseOrderNumber, purchaseRequisitionNumber
            'detailItem.*.quantity' => 'nullable|numeric|max:999000000000.999999',
            'detailItem.*.receiveItemNumber' => 'nullable|string', // Priority: receiveItemNumber, purchaseOrderNumber, purchaseRequisitionNumber
            'detailItem.*.useTax1' => 'nullable|boolean',
            'detailItem.*.useTax2' => 'nullable|boolean',
            'detailItem.*.useTax3' => 'nullable|boolean',
            'detailItem.*.warehouseName' => 'nullable|string',
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
            'vendorNo.required' => 'Nomor identitas vendor wajib diisi.',
            'detailItem.*.itemNo.required_with' => 'Nomor/Kode barang wajib diisi untuk setiap detail barang.',
            'detailItem.*.unitPrice.required_with' => 'Harga jual barang/jasa wajib diisi untuk setiap detail barang.',
            '*.numeric' => 'Kolom :attribute harus berupa angka.',
            '*.integer' => 'Kolom :attribute harus berupa angka non-desimal.',
            '*.string' => 'Kolom :attribute harus berupa teks.',
            '*.boolean' => 'Kolom :attribute harus berupa true atau false.',
            '*.date_format' => 'Kolom :attribute harus dalam format tanggal DD/MM/YYYY.',
            '*.max' => 'Nilai :attribute melebihi batas maksimum.',
            '*.in' => 'Nilai :attribute tidak valid.',
        ];
    }
}
