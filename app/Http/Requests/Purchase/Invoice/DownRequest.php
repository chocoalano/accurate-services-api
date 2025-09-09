<?php

namespace App\Http\Requests\Purchase\Invoice;

use Illuminate\Foundation\Http\FormRequest as BaseRequest;

class DownRequest extends BaseRequest
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
            'billNumber' => 'required|string',
            'dpAmount' => 'required|numeric|max:999000000000.999999', // Max 999 miliar dengan 6 desimal
            'vendorNo' => 'required|string',
            'branchName' => 'nullable|string',
            'currencyCode' => 'nullable|string',
            'description' => 'nullable|string',
            'documentCode' => 'nullable|in:CTAS_IMPORT,CTAS_INVOICE,CTAS_PURCHASE,CTAS_UNCREDIT,DIGUNGGUNG', // Ganti dengan nilai aktual yang diizinkan
            'documentTransaction' => 'nullable|in:CTAS_DOKUMEN_KHUSUS,CTAS_PEMBAYARAN,CTAS_PEMBERITAHUAN_IMPORT,CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN,CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH', // Ganti dengan nilai aktual yang diizinkan
            'fiscalRate' => 'nullable|numeric|max:999000000000.999999',
            'inclusiveTax' => 'nullable|boolean',
            'isTaxable' => 'nullable|boolean',
            'number' => 'nullable|string',
            'paymentTermName' => 'nullable|string',
            'poNumber' => 'nullable|string',
            'rate' => 'nullable|numeric|max:999000000000.999999',
            'tax1Name' => 'nullable|string',
            'taxDate' => 'nullable|date_format:d/m/Y',
            'taxNumber' => 'nullable|string',
            'toAddress' => 'nullable|string',
            'transDate' => 'nullable|date_format:d/m/Y',
            'typeAutoNumber' => 'nullable|integer',
            'vendorTaxType' => 'nullable|in:CTAS_BESARAN_TERTENTU,CTAS_DPP_NILAI_LAIN,CTAS_IMPOR_BARANG_KENA_PAJAK,CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI,CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH,CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH,CTAS_KEPADA_SELAIN_PEMUNGUT_PPN,CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK,CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN,CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN,CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT,CTAS_PENYERAHAN_LAINNYA', // Ganti dengan nilai aktual yang diizinkan
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
            'billNumber.required' => 'Nomor referensi tagihan dari pemasok wajib diisi.',
            'dpAmount.required' => 'Nilai uang muka penjualan wajib diisi.',
            'vendorNo.required' => 'Nomor identitas vendor wajib diisi.',
            'dpAmount.numeric' => 'Nilai uang muka penjualan harus berupa angka.',
            'dpAmount.max' => 'Nilai uang muka penjualan melebihi batas maksimum (999 miliar dengan 6 desimal).',
            'fiscalRate.numeric' => 'Kurs pajak (fiskal) harus berupa angka.',
            'fiscalRate.max' => 'Kurs pajak (fiskal) melebihi batas maksimum (999 miliar dengan 6 desimal).',
            'rate.numeric' => 'Nilai tukar mata uang harus berupa angka.',
            'rate.max' => 'Nilai tukar mata uang melebihi batas maksimum (999 miliar dengan 6 desimal).',
            'typeAutoNumber.integer' => 'ID record penomoran transaksi harus berupa angka non-desimal.',
            'transDate.date_format' => 'Tanggal transaksi harus dalam format DD/MM/YYYY.',
            'taxDate.date_format' => 'Tanggal pencatatan pajak harus dalam format DD/MM/YYYY.',
            'inclusiveTax.boolean' => 'Kolom inclusiveTax harus berupa true atau false.',
            'isTaxable.boolean' => 'Kolom isTaxable harus berupa true atau false.',
            'documentCode.in' => 'Jenis Dokumen Pajak yang dipilih tidak valid.',
            'documentTransaction.in' => 'Transaksi Dokumen Pajak yang dipilih tidak valid.',
            'vendorTaxType.in' => 'Detail Transaksi Vendor Tax Type yang dipilih tidak valid.',
        ];
    }
}
