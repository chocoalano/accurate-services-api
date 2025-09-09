<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormCustomerRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'transDate' => ['required', 'date_format:d/m/Y'],

            'billCity' => ['nullable', 'string'],
            'billCountry' => ['nullable', 'string'],
            'billProvince' => ['nullable', 'string'],
            'billStreet' => ['nullable', 'string'],
            'billZipCode' => ['nullable', 'string'],

            'branchId' => ['nullable', 'integer'],
            'branchName' => ['nullable', 'string'],
            'categoryName' => ['nullable', 'string'],
            'consignmentStore' => ['nullable', 'boolean'],
            'currencyCode' => ['nullable', 'string'],

            'customerDownPaymentAccountListNo' => ['nullable', 'array'],
            'customerDownPaymentAccountListNo.*' => ['string'],

            'customerLimitAge' => ['nullable', 'boolean'],
            'customerLimitAgeValue' => ['nullable', 'integer'],

            'customerLimitAmount' => ['nullable', 'boolean'],
            'customerLimitAmountValue' => ['nullable', 'numeric'],

            'customerNo' => ['nullable', 'string'],

            'customerReceivableAccountListNo' => ['nullable', 'array'],
            'customerReceivableAccountListNo.*' => ['string'],

            'customerTaxType' => [
                'nullable',
                Rule::in([
                    'CTAS_KEPADA_SELAIN_PEMUNGUT_PPN',
                    'CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH',
                    'CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH',
                    'CTAS_EKSPOR_BARANG_BERWUJUD',
                    'CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD',
                    'CTAS_EKSPOR_JASA',
                    'CTAS_DPP_NILAI_LAIN',
                    'CTAS_BESARAN_TERTENTU',
                    'CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI',
                    'CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT',
                    'CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN',
                    'CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN',
                ]),
            ],
            'defaultIncTax' => ['nullable', 'boolean'],
            'defaultSalesDisc' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],

            'detailContact' => ['nullable', 'array'],
            'detailContact.*.bbmPin' => ['nullable', 'string'],
            'detailContact.*.email' => ['nullable', 'string', 'email'],
            'detailContact.*.fax' => ['nullable', 'string'],
            'detailContact.*.homePhone' => ['nullable', 'string'],
            'detailContact.*.id' => ['nullable', 'integer'],
            'detailContact.*.mobilePhone' => ['nullable', 'string'],
            'detailContact.*.name' => ['nullable', 'string'],
            'detailContact.*.notes' => ['nullable', 'string'],
            'detailContact.*.position' => ['nullable', 'string'],
            'detailContact.*.salutation' => ['nullable', 'string'],
            'detailContact.*.website' => ['nullable', 'string', 'url'],
            'detailContact.*.workPhone' => ['nullable', 'string'],

            'detailOpenBalance' => ['nullable', 'array'],
            'detailOpenBalance.*._status' => ['nullable', 'string'],
            'detailOpenBalance.*.amount' => ['nullable', 'numeric'],
            'detailOpenBalance.*.asOf' => ['nullable', 'date_format:d/m/Y'],
            'detailOpenBalance.*.currencyCode' => ['nullable', 'string'],
            'detailOpenBalance.*.description' => ['nullable', 'string'],
            'detailOpenBalance.*.id' => ['nullable', 'integer'],
            'detailOpenBalance.*.number' => ['nullable', 'string'],
            'detailOpenBalance.*.paymentTermName' => ['nullable', 'string'],
            'detailOpenBalance.*.rate' => ['nullable', 'numeric'],
            'detailOpenBalance.*.typeAutoNumber' => ['nullable', 'integer'],

            'detailShipAddress' => ['nullable', 'array'],
            'detailShipAddress.*._status' => ['nullable', 'string'],
            'detailShipAddress.*.city' => ['nullable', 'string'],
            'detailShipAddress.*.country' => ['nullable', 'string'],
            'detailShipAddress.*.id' => ['nullable', 'integer'],
            'detailShipAddress.*.province' => ['nullable', 'string'],
            'detailShipAddress.*.street' => ['nullable', 'string'],
            'detailShipAddress.*.zipCode' => ['nullable', 'string'],

            'discountCategoryName' => ['nullable', 'string'],
            'email' => ['nullable', 'string', 'email'],
            'fax' => ['nullable', 'string'],
            'id' => ['nullable', 'integer'],
            'mobilePhone' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'npwpNo' => ['nullable', 'string'],
            'number' => ['nullable', 'string'],
            'pkpNo' => ['nullable', 'string'],
            'priceCategoryName' => ['nullable', 'string'],

            'salesmanListNumber' => ['nullable', 'array'],
            'salesmanListNumber.*' => ['string'],

            'salesmanNumber' => ['nullable', 'string'],

            'shipCity' => ['nullable', 'string'],
            'shipCountry' => ['nullable', 'string'],
            'shipProvince' => ['nullable', 'string'],
            'shipSameAsBill' => ['nullable', 'boolean'],
            'shipStreet' => ['nullable', 'string'],
            'shipZipCode' => ['nullable', 'string'],

            'taxCity' => ['nullable', 'string'],
            'taxCountry' => ['nullable', 'string'],
            'taxProvince' => ['nullable', 'string'],
            'taxSameAsBill' => ['nullable', 'boolean'],
            'taxStreet' => ['nullable', 'string'],
            'taxZipCode' => ['nullable', 'string'],

            'termName' => ['nullable', 'string'],
            'typeAutoNumber' => ['nullable', 'integer'],
            'website' => ['nullable', 'string', 'url'],
            'workPhone' => ['nullable', 'string'],
            'wpName' => ['nullable', 'string'],
        ];
    }
}
