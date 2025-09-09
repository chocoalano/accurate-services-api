<?php

namespace App\Http\Requests\Purchase\Payment;

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
            'bankNo' => 'required|string',
            'chequeAmount' => 'required|numeric|max:999000000000.999999', // Max 999 miliar dengan 6 desimal
            'transDate' => 'required|date_format:d/m/Y',
            'vendorNo' => 'required|string',
            'branchId' => 'nullable|integer',
            'branchName' => 'nullable|string',
            'chequeDate' => 'nullable|date_format:d/m/Y',
            'chequeNo' => 'nullable|string',
            'currencyCode' => 'nullable|string',
            'description' => 'nullable|string',
            'id' => 'nullable|integer',
            'number' => 'nullable|string',
            'paymentMethod' => 'nullable|in: BANK_CHEQUE,BANK_TRANSFER,CASH_OTHER,EDC,OTHERS,PAYMENT_LINK,QRIS,VIRTUAL_ACCOUNT', // Contoh nilai yang dapat digunakan
            'rate' => 'nullable|numeric|max:999000000000.999999',
            'typeAutoNumber' => 'nullable|integer',

            // detailInvoice[n]
            'detailInvoice' => 'required|array', // Asumsi detailInvoice wajib ada karena ada invoiceNo dan paymentAmount required di dalamnya
            'detailInvoice.*.invoiceNo' => 'required|string',
            'detailInvoice.*.paymentAmount' => 'required|numeric|max:999000000000.999999',
            'detailInvoice.*._status' => 'nullable|in:delete',
            'detailInvoice.*.id' => 'nullable|integer',
            'detailInvoice.*.paidPph' => 'nullable|boolean',
            'detailInvoice.*.pphNumber' => 'nullable|string',

            // detailInvoice[n].detailDiscount[n]
            'detailInvoice.*.detailDiscount' => 'nullable|array',
            'detailInvoice.*.detailDiscount.*.accountNo' => 'required|string', // Wajib jika detailDiscount ada
            'detailInvoice.*.detailDiscount.*.amount' => 'required|numeric|max:999000000000.999999', // Wajib jika detailDiscount ada
            'detailInvoice.*.detailDiscount.*._status' => 'nullable|in:delete',
            'detailInvoice.*.detailDiscount.*.departmentName' => 'nullable|string',
            'detailInvoice.*.detailDiscount.*.discountNotes' => 'nullable|string',
            'detailInvoice.*.detailDiscount.*.id' => 'nullable|integer',
            'detailInvoice.*.detailDiscount.*.projectNo' => 'nullable|string',
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
            'bankNo.required' => 'Nomor akun perkiraan bank wajib diisi.',
            'chequeAmount.required' => 'Jumlah cek wajib diisi.',
            'chequeAmount.numeric' => 'Jumlah cek harus berupa angka.',
            'chequeAmount.max' => 'Jumlah cek melebihi batas maksimum.',
            'transDate.required' => 'Tanggal transaksi wajib diisi.',
            'transDate.date_format' => 'Tanggal transaksi harus dalam format DD/MM/YYYY.',
            'vendorNo.required' => 'Nomor identitas vendor wajib diisi.',

            'detailInvoice.required' => 'Detail faktur yang dibayar wajib diisi.',
            'detailInvoice.array' => 'Detail faktur harus berupa array.',
            'detailInvoice.*.invoiceNo.required' => 'Nomor faktur wajib diisi untuk setiap detail pembayaran.',
            'detailInvoice.*.paymentAmount.required' => 'Nilai pembayaran wajib diisi untuk setiap detail pembayaran.',
            'detailInvoice.*.paymentAmount.numeric' => 'Nilai pembayaran harus berupa angka untuk setiap detail pembayaran.',
            'detailInvoice.*.paymentAmount.max' => 'Nilai pembayaran melebihi batas maksimum untuk setiap detail pembayaran.',
            'detailInvoice.*._status.in' => 'Status detail faktur tidak valid.',
            'detailInvoice.*.id.integer' => 'ID detail faktur harus berupa angka non-desimal.',
            'detailInvoice.*.paidPph.boolean' => 'Paid PPH harus berupa true atau false.',

            'detailInvoice.*.detailDiscount.*.accountNo.required' => 'Nomor akun diskon wajib diisi untuk setiap detail diskon.',
            'detailInvoice.*.detailDiscount.*.amount.required' => 'Nilai diskon wajib diisi untuk setiap detail diskon.',
            'detailInvoice.*.detailDiscount.*.amount.numeric' => 'Nilai diskon harus berupa angka untuk setiap detail diskon.',
            'detailInvoice.*.detailDiscount.*.amount.max' => 'Nilai diskon melebihi batas maksimum untuk setiap detail diskon.',
            'detailInvoice.*.detailDiscount.*._status.in' => 'Status detail diskon tidak valid.',
            'detailInvoice.*.detailDiscount.*.id.integer' => 'ID detail diskon harus berupa angka non-desimal.',

            'branchId.integer' => 'ID cabang harus berupa angka non-desimal.',
            'chequeDate.date_format' => 'Tanggal cek harus dalam format DD/MM/YYYY.',
            'id.integer' => 'ID transaksi harus berupa angka non-desimal.',
            'paymentMethod.in' => 'Metode pembayaran yang dipilih tidak valid.',
            'rate.numeric' => 'Nilai tukar mata uang harus berupa angka.',
            'rate.max' => 'Nilai tukar mata uang melebihi batas maksimum.',
            'typeAutoNumber.integer' => 'ID penomoran otomatis harus berupa angka non-desimal.',
        ];
    }
}
