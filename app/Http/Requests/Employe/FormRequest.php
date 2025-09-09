<?php

namespace App\Http\Requests\Employe;

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

    public function rules()
    {
        return [
            // Field Wajib
            'name' => ['required', 'string', 'max:255'],
            'salutation' => [
                'required',
                'string',
                Rule::in([
                    'MR',
                    'MRS',
                ])
            ],
            'transDate' => ['required', 'date_format:d/m/Y'], // Format contoh: 31/03/2016

            // Field Opsional
            'bankAccount' => ['nullable', 'string', 'max:255'],
            'bankAccountName' => ['nullable', 'string', 'max:255'],
            'bankCode' => ['nullable', 'string', 'max:255'],
            'bankName' => ['nullable', 'string', 'max:255'],
            'bbmPin' => ['nullable', 'string', 'max:255'], // Asumsi BBM Pin adalah string
            'branchId' => ['nullable', 'integer', 'min:1'],
            'branchName' => ['nullable', 'string', 'max:255'],
            'calculatePtkp' => ['nullable', 'boolean'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'departmentName' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'domisiliType' => [
                'nullable',
                'string',
                Rule::in([
                    'ARE', // Uni Emirat Arab
                    'AUS', // Australia
                    'AUT', // Austria
                    'BEL', // Belgia
                    'BGD', // Bangladesh
                    'BGR', // Bulgaria
                    'BRN', // Brunei Darussalam
                    'CAN', // Kanada
                    'CHE', // Swiss
                    'CHN', // China
                    'CZE', // Republik Ceko
                    'DEU', // Jerman
                    'DNK', // Denmark
                    'DZA', // Aljazair
                    'EGY', // Mesir
                    'ESP', // Spanyol
                    'FIN', // Finlandia
                    'FRA', // Perancis
                    'GBR', // Inggris
                    'HKG', // Hong Kong
                    'HUN', // Hungaria
                    'INA', // Indonesia
                    'IND', // India
                    'IRN', // Iran
                    'ITA', // Italia
                    'JOR', // Yordania
                    'JPN', // Jepang
                    'KOR', // Korea Selatan
                    'KWT', // Kuwait
                    'LKA', // Sri Lanka
                    'LUX', // Luxembourg
                    'MAR', // Maroko
                    'MNG', // Mongolia
                    'MYS', // Malaysia
                    'NLD', // Belanda
                    'NOR', // Norwegia
                    'NZL', // Selandia Baru
                    'PAK', // Pakistan
                    'PHL', // Philipina
                    'POL', // Polandia
                    'PRK', // Korea Utara
                    'PRT', // Portugal
                    'QAT', // Qatar
                    'ROU', // Romania
                    'RUS', // Rusia
                    'SAU', // Saudi Arabia
                    'SDN', // Sudan
                    'SGP', // Singapura
                    'SVK', // Slovakia
                    'SWE', // Swedia
                    'SYC', // Seychelles
                    'SYR', // Suriah
                    'THA', // Thailand
                    'TUN', // Tunisia
                    'TUR', // Turki
                    'TWN', // Taiwan
                    'UKR', // Ukraina
                    'USA', // Amerika Serikat
                    'UZB', // Uzbekistan
                    'VEN', // Venezuela
                    'VNM', // Vietnam
                    'ZAF', // Afrika Selatan (saya asumsikan ini adalah 'ZAF' karena itu adalah kode ISO 3166-1 alpha-3 yang umum setelah VNM)
                ])
            ],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'employeeTaxStatus' => [
                'nullable',
                'string',
                Rule::in([
                    'K0',
                    'K1',
                    'K2',
                    'K3',
                    'TK0',
                    'TK1',
                    'TK2',
                    'TK3',
                ])
            ],
            'employeeWorkStatus' => [
                'nullable',
                'string',
                Rule::in([
                    'ANGGOTA_DEWAN_KOMISARIS',
                    'BUKAN_PEGAWAI_BUKAN_PEGAWAI_IMBALAN_SINAMBUNGAN',
                    'BUKAN_PEGAWAI_BUKAN_PEGAWAI_IMBALAN_TIDAK_SINAMBUNGAN',
                    'BUKAN_PEGAWAI_DISTRIBUTOR_MLM',
                    'BUKAN_PEGAWAI_PENJAJA_DAGANGAN',
                    'BUKAN_PEGAWAI_PETUGAS_ASURANSI',
                    'BUKAN_PEGAWAI_TENAGA_AHLI',
                    'MANTAN_PEGAWAI_TERIMA_IMBALAN',
                    'PEGAWAI_TARIK_PENSIUN',
                    'PEGAWAI_TETAP',
                    'PEGAWAI_TIDAK_TETAP',
                    'PEGAWAI_WAJIB_PAJAK_LUAR_NEGERI',
                    'PENERIMA_MANFAAT_DIBAYARKAN_SEKALIGUS',
                    'PENERIMA_PENGHASILAN_DIPOTONG_PPH21_FINAL',
                    'PENERIMA_PENGHASILAN_DIPOTONG_PPH21_TIDAK_FINAL',
                    'PENERIMA_PENSIUN_BERKALA',
                    'PENERIMA_PESANGON_SEKALIGUS',
                    'PESERTA_KEGIATAN',
                ])
            ],
            'homePhone' => ['nullable', 'string', 'max:255'],
            'id' => ['nullable', 'integer', 'min:1'],
            'joinDate' => ['nullable', 'date_format:d/m/Y'],
            'mobilePhone' => ['nullable', 'string', 'max:255'],
            'nettoIncomeBefore' => ['nullable', 'numeric', 'min:0', 'max:999000000000', 'regex:/^\d+(\.\d{1,6})?$/'], // Max 999 miliar dengan 6 digit desimal
            'nikNo' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'npwpNo' => ['nullable', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'pph' => ['nullable', 'boolean'],
            'pphBefore' => ['nullable', 'numeric', 'min:0', 'max:999000000000', 'regex:/^\d+(\.\d{1,6})?$/'],
            'province' => ['nullable', 'string', 'max:255'],
            'salesman' => ['nullable', 'boolean'],
            'startMonthPayment' => ['nullable', 'integer', 'min:1', 'max:12'],
            'startYearPayment' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)], // Batasan tahun bisa disesuaikan
            'street' => ['nullable', 'string', 'max:255'],
            'suspended' => ['nullable', 'boolean'],
            'typeAutoNumber' => ['nullable', 'integer', 'min:1'],
            'website' => ['nullable', 'string', 'url', 'max:255'],
            'workPhone' => ['nullable', 'string', 'max:255'],
            'zipCode' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nama Karyawan wajib diisi.',
            'name.string' => 'Nama Karyawan harus berupa teks.',
            'name.max' => 'Nama Karyawan tidak boleh lebih dari :max karakter.',
            'salutation.required' => 'Sapaan wajib diisi.',
            'salutation.string' => 'Sapaan harus berupa teks.',
            'salutation.in' => 'Sapaan yang dipilih tidak valid.',
            'transDate.required' => 'Tanggal pengakuan wajib diisi.',
            'transDate.date_format' => 'Format Tanggal pengakuan harus DD/MM/YYYY. Contoh: 31/03/2016.',
            'bankAccount.string' => 'Nomor Rekening harus berupa teks.',
            'bankAccountName.string' => 'Atas Nama Rekening harus berupa teks.',
            'bankCode.string' => 'Kode Bank harus berupa teks.',
            'bankName.string' => 'Nama Bank harus berupa teks.',
            'bbmPin.string' => 'Nomor WhatsApp harus berupa teks.',
            'branchId.integer' => 'ID Cabang harus berupa angka non-desimal.',
            'branchId.min' => 'ID Cabang minimal 1.',
            'branchName.string' => 'Nama Cabang harus berupa teks.',
            'calculatePtkp.boolean' => 'Dikenakan PTKP harus berupa nilai benar atau salah (true/false).',
            'city.string' => 'Nama Kota harus berupa teks.',
            'country.string' => 'Nama Negara harus berupa teks.',
            'departmentName.string' => 'Departemen harus berupa teks.',
            'description.string' => 'Catatan tambahan harus berupa teks.',
            'domisiliType.string' => 'Kewarganegaraan harus berupa teks.',
            'domisiliType.in' => 'Kewarganegaraan yang dipilih tidak valid.',
            'email.string' => 'Alamat Email harus berupa teks.',
            'email.email' => 'Alamat Email harus dalam format yang valid.',
            'email.max' => 'Alamat Email tidak boleh lebih dari :max karakter.',
            'employeeTaxStatus.string' => 'Status PTKP harus berupa teks.',
            'employeeTaxStatus.in' => 'Status PTKP yang dipilih tidak valid.',
            'employeeWorkStatus.string' => 'Status Pekerja harus berupa teks.',
            'employeeWorkStatus.in' => 'Status Pekerja yang dipilih tidak valid.',
            'homePhone.string' => 'Nomor telepon rumah harus berupa teks.',
            'id.integer' => 'ID harus berupa angka non-desimal.',
            'id.min' => 'ID minimal 1.',
            'joinDate.date_format' => 'Format Tanggal Masuk harus DD/MM/YYYY. Contoh: 31/03/2016.',
            'mobilePhone.string' => 'Nomor handphone harus berupa teks.',
            'nettoIncomeBefore.numeric' => 'Penghasilan Sebelumnya harus berupa angka.',
            'nettoIncomeBefore.min' => 'Penghasilan Sebelumnya tidak boleh kurang dari 0.',
            'nettoIncomeBefore.max' => 'Penghasilan Sebelumnya tidak boleh lebih dari 999 miliar.',
            'nettoIncomeBefore.regex' => 'Penghasilan Sebelumnya harus memiliki maksimal 6 digit desimal.',
            'nikNo.string' => 'Nomor KTP harus berupa teks.',
            'notes.string' => 'Catatan harus berupa teks.',
            'npwpNo.string' => 'Nomor NPWP harus berupa teks.',
            'number.string' => 'ID Karyawan harus berupa teks.',
            'position.string' => 'Posisi Jabatan harus berupa teks.',
            'pph.boolean' => 'Dikenakan PPh 21 harus berupa nilai benar atau salah (true/false).',
            'pphBefore.numeric' => 'PPH Sebelumnya harus berupa angka.',
            'pphBefore.min' => 'PPH Sebelumnya tidak boleh kurang dari 0.',
            'pphBefore.max' => 'PPH Sebelumnya tidak boleh lebih dari 999 miliar.',
            'pphBefore.regex' => 'PPH Sebelumnya harus memiliki maksimal 6 digit desimal.',
            'province.string' => 'Nama Provinsi harus berupa teks.',
            'salesman.boolean' => 'Penjual harus berupa nilai benar atau salah (true/false).',
            'startMonthPayment.integer' => 'Bulan Mulai Gajian harus berupa angka non-desimal.',
            'startMonthPayment.min' => 'Bulan Mulai Gajian minimal 1.',
            'startMonthPayment.max' => 'Bulan Mulai Gajian maksimal 12.',
            'startYearPayment.integer' => 'Tahun Mulai Gajian harus berupa angka non-desimal.',
            'startYearPayment.min' => 'Tahun Mulai Gajian minimal 1900.',
            'startYearPayment.max' => 'Tahun Mulai Gajian tidak boleh lebih dari tahun sekarang + 1.',
            'street.string' => 'Nama Jalan harus berupa teks.',
            'suspended.boolean' => 'Non Aktif harus berupa nilai benar atau salah (true/false).',
            'typeAutoNumber.integer' => 'ID Penomoran Transaksi harus berupa angka non-desimal.',
            'typeAutoNumber.min' => 'ID Penomoran Transaksi minimal 1.',
            'website.string' => 'Alamat Website harus berupa teks.',
            'website.url' => 'Alamat Website harus dalam format URL yang valid.',
            'website.max' => 'Alamat Website tidak boleh lebih dari :max karakter.',
            'workPhone.string' => 'Nomor telepon kantor harus berupa teks.',
            'zipCode.string' => 'Kode Pos harus berupa teks.',
        ];
    }
}
