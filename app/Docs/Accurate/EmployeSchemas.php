<?php

namespace App\Docs\Accurate;

/**
 * --- NESTED SCHEMAS FOR EMPLOYE INPUT & DATA ---
 *
 * @OA\Schema(
 * schema="EmployeDetailCommonFields",
 * title="Fields Umum Detail Karyawan",
 * description="Properti umum untuk detail Expense, Material, Extra Finish Good, dll., yang mungkin ada di konteks Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Classification A"),
 * @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="IT Department"),
 * @OA\Property(property="detailName", type="string", nullable=true, example="Nama Detail Contoh"),
 * @OA\Property(property="detailNotes", type="string", nullable=true, example="Catatan untuk detail ini."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="itemUnitName", type="string", nullable=true, example="PCS"),
 * @OA\Property(property="processCategoryName", type="string", nullable=true, example="Category A"),
 * @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-001"),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus baris).")
 * }
 * )
 *
 * @OA\Schema(
 * schema="EmployeDetailExpenseItem",
 * title="Item Detail Biaya Karyawan",
 * description="Detail biaya terkait karyawan dalam input atau respon.",
 * type="object",
 * allOf={
 * @OA\Schema(ref="#/components/schemas/EmployeDetailCommonFields")
 * },
 * properties={
 * @OA\Property(property="itemNo", type="string", example="EXP001", description="Nomor item biaya."),
 * @OA\Property(property="quantity", type="number", format="double", example=100.5, description="Kuantitas item biaya.")
 * },
 * required={"itemNo", "quantity"}
 * )
 *
 * @OA\Schema(
 * schema="EmployeDetailMaterialItem",
 * title="Item Detail Material Karyawan",
 * description="Detail material terkait karyawan dalam input atau respon.",
 * type="object",
 * allOf={
 * @OA\Schema(ref="#/components/schemas/EmployeDetailCommonFields")
 * },
 * properties={
 * @OA\Property(property="itemNo", type="string", example="MAT001", description="Nomor item material."),
 * @OA\Property(property="quantity", type="number", format="double", example=50.0, description="Kuantitas item material.")
 * },
 * required={"itemNo", "quantity"}
 * )
 *
 * @OA\Schema(
 * schema="EmployeDetailExtraFinishGoodItem",
 * title="Item Detail Hasil Jadi Tambahan Karyawan",
 * description="Detail produk hasil jadi tambahan terkait karyawan dalam input atau respon.",
 * type="object",
 * allOf={
 * @OA\Schema(ref="#/components/schemas/EmployeDetailCommonFields")
 * },
 * properties={
 * @OA\Property(property="itemNo", type="string", example="FG-EXTRA01", description="Nomor item hasil jadi tambahan."),
 * @OA\Property(property="quantity", type="number", format="double", example=5.0, description="Kuantitas item hasil jadi tambahan."),
 * @OA\Property(property="portion", type="number", format="double", nullable=true, example=0.5, description="Porsi produk jadi tambahan.")
 * },
 * required={"itemNo", "quantity"}
 * )
 *
 * @OA\Schema(
 * schema="EmployeDetailProcessItem",
 * title="Item Detail Proses Karyawan",
 * description="Detail proses terkait karyawan dalam input atau respon.",
 * type="object",
 * properties={
 * @OA\Property(property="processCategoryName", type="string", example="Onboarding", description="Nama kategori proses."),
 * @OA\Property(property="sortNumber", type="integer", example=1, description="Nomor urut proses."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="instruction", type="string", nullable=true, example="Lakukan verifikasi dokumen."),
 * @OA\Property(property="subCon", type="boolean", nullable=true, example=false, description="Menunjukkan apakah ini subkontraktor."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus baris).")
 * },
 * required={"processCategoryName", "sortNumber"}
 * )
 *
 * @OA\Schema(
 * schema="EmployeInput",
 * title="Input Data Karyawan",
 * description="Skema lengkap untuk data input saat membuat atau memperbarui karyawan.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=101, description="ID unik internal karyawan. Diperlukan untuk operasi update, null/kosong untuk create."),
 * @OA\Property(property="name", type="string", example="Budi Santoso", description="Nama karyawan. Wajib."),
 * @OA\Property(property="salutation", type="string", enum={"MR", "MRS"}, example="MR", description="Sapaan atau gelar karyawan. Wajib."),
 * @OA\Property(property="transDate", type="string", format="date", example="31/03/2016", description="Tanggal transaksi (DD/MM/YYYY). Wajib."),
 * @OA\Property(property="bankAccount", type="string", nullable=true, example="1234567890", description="Nomor rekening bank."),
 * @OA\Property(property="bankAccountName", type="string", nullable=true, example="Budi Santoso", description="Nama pemilik rekening bank."),
 * @OA\Property(property="bankCode", type="string", nullable=true, example="014", description="Kode bank."),
 * @OA\Property(property="bankName", type="string", nullable=true, example="Bank BCA", description="Nama bank."),
 * @OA\Property(property="bbmPin", type="string", nullable=true, example="081234567890", description="Nomor WhatsApp/BBM Pin."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=1, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Kantor Pusat", description="Nama cabang."),
 * @OA\Property(property="calculatePtkp", type="boolean", nullable=true, example=true, description="Menandakan apakah dikenakan PTKP."),
 * @OA\Property(property="city", type="string", nullable=true, example="Jakarta", description="Kota alamat pajak."),
 * @OA\Property(property="country", type="string", nullable=true, example="INA", description="Nama negara alamat pajak."),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Sales"),
 * @OA\Property(property="description", type="string", nullable=true, example="Pegawai baru divisi sales."),
 * @OA\Property(
 * property="domisiliType",
 * type="string",
 * nullable=true,
 * enum={
 * "ARE", "AUS", "AUT", "BEL", "BGD", "BGR", "BRN", "CAN", "CHE", "CHN", "CZE", "DEU", "DNK", "DZA", "EGY", "ESP", "FIN", "FRA", "GBR", "HKG", "HUN", "INA", "IND", "IRN", "ITA", "JOR", "JPN", "KOR", "KWT", "LKA", "LUX", "MAR", "MNG", "MYS", "NLD", "NOR", "NZL", "PAK", "PHL", "POL", "PRK", "PRT", "QAT", "ROU", "RUS", "SAU", "SDN", "SGP", "SVK", "SWE", "SYC", "SYR", "THA", "TUN", "TUR", "TWN", "UKR", "USA", "UZB", "VEN", "VNM", "ZAF"
 * },
 * example="INA",
 * description="Kewarganegaraan atau jenis domisili."
 * ),
 * @OA\Property(property="email", type="string", format="email", nullable=true, example="budi@example.com", description="Alamat email karyawan."),
 * @OA\Property(
 * property="employeeTaxStatus",
 * type="string",
 * nullable=true,
 * enum={"K0", "K1", "K2", "K3", "TK0", "TK1", "TK2", "TK3"},
 * example="K0",
 * description="Status PTKP (Penghasilan Tidak Kena Pajak)."
 * ),
 * @OA\Property(
 * property="employeeWorkStatus",
 * type="string",
 * nullable=true,
 * enum={
 * "ANGGOTA_DEWAN_KOMISARIS", "BUKAN_PEGAWAI_BUKAN_PEGAWAI_IMBALAN_SINAMBUNGAN", "BUKAN_PEGAWAI_BUKAN_PEGAWAI_IMBALAN_TIDAK_SINAMBUNGAN", "BUKAN_PEGAWAI_DISTRIBUTOR_MLM", "BUKAN_PEGAWAI_PENJAJA_DAGANGAN", "BUKAN_PEGAWAI_PETUGAS_ASURANSI", "BUKAN_PEGAWAI_TENAGA_AHLI", "MANTAN_PEGAWAI_TERIMA_IMBALAN", "PEGAWAI_TARIK_PENSIUN", "PEGAWAI_TETAP", "PEGAWAI_TIDAK_TETAP", "PEGAWAI_WAJIB_PAJAK_LUAR_NEGERI", "PENERIMA_MANFAAT_DIBAYARKAN_SEKALIGUS", "PENERIMA_PENGHASILAN_DIPOTONG_PPH21_FINAL", "PENERIMA_PENGHASILAN_DIPOTONG_PPH21_TIDAK_FINAL", "PENERIMA_PENSIUN_BERKALA", "PENERIMA_PESANGON_SEKALIGUS", "PESERTA_KEGIATAN"
 * },
 * example="PEGAWAI_TETAP",
 * description="Status Pekerja."
 * ),
 * @OA\Property(property="homePhone", type="string", nullable=true, example="0211234567", description="Nomor telepon rumah."),
 * @OA\Property(property="joinDate", type="string", format="date", nullable=true, example="01/01/2024", description="Tanggal masuk kerja (DD/MM/YYYY)."),
 * @OA\Property(property="mobilePhone", type="string", nullable=true, example="08123456789", description="Nomor telepon seluler."),
 * @OA\Property(property="nettoIncomeBefore", type="number", format="double", nullable=true, example=7500000.50, description="Penghasilan netto sebelumnya (maks. 6 desimal)."),
 * @OA\Property(property="nikNo", type="string", nullable=true, example="3174001234567890", description="Nomor KTP (NIK)."),
 * @OA\Property(property="notes", type="string", nullable=true, example="Catatan tentang karyawan ini."),
 * @OA\Property(property="npwpNo", type="string", nullable=true, example="0123456789012345", description="Nomor NPWP."),
 * @OA\Property(property="number", type="string", nullable=true, example="EMP001", description="ID Karyawan (Accurate's internal number)."),
 * @OA\Property(property="position", type="string", nullable=true, example="Staff Penjualan", description="Posisi jabatan."),
 * @OA\Property(property="pph", type="boolean", nullable=true, example=true, description="Menandakan apakah dikenakan PPh 21."),
 * @OA\Property(property="pphBefore", type="number", format="double", nullable=true, example=150000.75, description="Penghasilan dan PPh sebelumnya (maks. 6 desimal)."),
 * @OA\Property(property="province", type="string", nullable=true, example="DKI Jakarta", description="Nama provinsi alamat pajak."),
 * @OA\Property(property="salesman", type="boolean", nullable=true, example=true, description="Menandakan apakah karyawan adalah penjual."),
 * @OA\Property(property="startMonthPayment", type="integer", nullable=true, minimum=1, maximum=12, example=1, description="Bulan mulai gajian."),
 * @OA\Property(property="startYearPayment", type="integer", nullable=true, minimum=1900, example=2024, description="Tahun mulai gajian."),
 * @OA\Property(property="street", type="string", nullable=true, example="Jl. Raya Barat No. 10", description="Nama jalan alamat pajak."),
 * @OA\Property(property="suspended", type="boolean", nullable=true, example=false, description="Status non-aktif karyawan."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="ID record penomoran transaksi yang ingin digunakan."),
 * @OA\Property(property="website", type="string", format="url", nullable=true, example="http://www.karyawan.com", description="Alamat website karyawan."),
 * @OA\Property(property="workPhone", type="string", nullable=true, example="0219876543", description="Nomor telepon kantor."),
 * @OA\Property(property="zipCode", type="string", nullable=true, example="12345", description="Kode pos alamat pajak."),
 * @OA\Property(property="detailExpense", type="array", nullable=true, @OA\Items(ref="#/components/schemas/EmployeDetailExpenseItem"), description="Detail daftar biaya."),
 * @OA\Property(property="detailMaterial", type="array", nullable=true, @OA\Items(ref="#/components/schemas/EmployeDetailMaterialItem"), description="Detail daftar material."),
 * @OA\Property(property="detailExtraFinishGood", type="array", nullable=true, @OA\Items(ref="#/components/schemas/EmployeDetailExtraFinishGoodItem"), description="Detail daftar hasil jadi tambahan."),
 * @OA\Property(property="detailProcess", type="array", nullable=true, @OA\Items(ref="#/components/schemas/EmployeDetailProcessItem"), description="Detail daftar proses.")
 * },
 * required={"name", "salutation", "transDate"}
 * )
 *
 * @OA\Schema(
 * schema="EmployeData",
 * title="Detail Data Karyawan",
 * description="Representasi lengkap data satu karyawan dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=2051, description="ID unik internal karyawan."),
 * @OA\Property(property="number", type="string", example="EMP-001", description="Nomor identifikasi karyawan (dari Accurate)."),
 * @OA\Property(property="name", type="string", example="Budi Santoso", description="Nama lengkap karyawan."),
 * @OA\Property(property="email", type="string", format="email", nullable=true, example="budi.santoso@example.com", description="Email karyawan."),
 * @OA\Property(property="mobilePhone", type="string", nullable=true, example="+6281234567890", description="Nomor telepon seluler."),
 * @OA\Property(property="position", type="string", nullable=true, example="Manager Penjualan", description="Jabatan karyawan."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=50, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Kantor Pusat", description="Nama cabang."),
 * @OA\Property(property="salesman", type="boolean", example=true, description="Menunjukkan apakah karyawan adalah seorang penjual."),
 * @OA\Property(property="suspended", type="boolean", example=false, description="Status penangguhan karyawan."),
 * @OA\Property(property="optLock", type="integer", example=1, description="Optimistic lock version."),
 * @OA\Property(property="createDate", type="string", format="date-time", example="2025-06-25 10:00:00", description="Tanggal pembuatan data."),
 * @OA\Property(property="lastUpdate", type="string", format="date-time", example="2025-06-25 11:00:00", description="Tanggal terakhir update data.")
 * },
 * required={"id", "number", "name", "suspended", "optLock", "createDate", "lastUpdate"}
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="EmployeListResponse",
 * title="Respons Daftar Karyawan",
 * description="Struktur respons untuk daftar karyawan dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/EmployeData"), description="Array daftar objek karyawan."),
 * @OA\Property(property="sp", type="object", description="Informasi paginasi",
 * properties={
 * @OA\Property(property="page", type="integer", example=1),
 * @OA\Property(property="pageSize", type="integer", example=50),
 * @OA\Property(property="pageCount", type="integer", example=1),
 * @OA\Property(property="rowCount", type="integer", example=5),
 * @OA\Property(property="start", type="integer", example=0)
 * }
 * )
 * }
 * )
 * },
 * required={"success", "status", "data"}
 * )
 *
 * @OA\Schema(
 * schema="EmployeFormAttributesResponse",
 * title="Atribut Form Karyawan",
 * description="Daftar opsi dan atribut yang diperlukan untuk form pembuatan/pengeditan karyawan.",
 * type="object",
 * properties={
 * @OA\Property(property="salutationType", type="array", @OA\Items(type="string", enum={"MR", "MRS"}), description="Opsi tipe sapaan."),
 * @OA\Property(
 * property="domisiliType",
 * type="array",
 * @OA\Items(
 * type="string",
 * enum={
 * "ARE", "AUS", "AUT", "BEL", "BGD", "BGR", "BRN", "CAN", "CHE", "CHN", "CZE", "DEU", "DNK", "DZA", "EGY", "ESP", "FIN", "FRA", "GBR", "HKG", "HUN", "INA", "IND", "IRN", "ITA", "JOR", "JPN", "KOR", "KWT", "LKA", "LUX", "MAR", "MNG", "MYS", "NLD", "NOR", "NZL", "PAK", "PHL", "POL", "PRK", "PRT", "QAT", "ROU", "RUS", "SAU", "SDN", "SGP", "SVK", "SWE", "SYC", "SYR", "THA", "TUN", "TUR", "TWN", "UKR", "USA", "UZB", "VEN", "VNM", "ZAF"
 * }
 * ),
 * description="Opsi tipe domisili."
 * ),
 * @OA\Property(property="employeeTaxStatusType", type="array", @OA\Items(type="string", enum={"K0", "K1", "K2", "K3", "TK0", "TK1", "TK2", "TK3"}), description="Opsi status pajak karyawan."),
 * @OA\Property(
 * property="employeeWorkStatusType",
 * type="array",
 * @OA\Items(
 * type="string",
 * enum={
 * "ANGGOTA_DEWAN_KOMISARIS", "BUKAN_PEGAWAI_BUKAN_PEGAWAI_IMBALAN_SINAMBUNGAN", "BUKAN_PEGAWAI_BUKAN_PEGAWAI_IMBALAN_TIDAK_SINAMBUNGAN", "BUKAN_PEGAWAI_DISTRIBUTOR_MLM", "BUKAN_PEGAWAI_PENJAJA_DAGANGAN", "BUKAN_PEGAWAI_PETUGAS_ASURANSI", "BUKAN_PEGAWAI_TENAGA_AHLI", "MANTAN_PEGAWAI_TERIMA_IMBALAN", "PEGAWAI_TARIK_PENSIUN", "PEGAWAI_TETAP", "PEGAWAI_TIDAK_TETAP", "PEGAWAI_WAJIB_PAJAK_LUAR_NEGERI", "PENERIMA_MANFAAT_DIBAYARKAN_SEKALIGUS", "PENERIMA_PENGHASILAN_DIPOTONG_PPH21_FINAL", "PENERIMA_PENGHASILAN_DIPOTONG_PPH21_TIDAK_FINAL", "PENERIMA_PENSIUN_BERKALA", "PENERIMA_PESANGON_SEKALIGUS", "PESERTA_KEGIATAN"
 * }
 * ),
 * description="Opsi status pekerjaan karyawan."
 * ),
 * @OA\Property(property="branch", type="array", @OA\Items(type="object", properties={@OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string")}), description="Daftar cabang yang tersedia."),
 * @OA\Property(property="departement", type="array", @OA\Items(type="object", properties={@OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string")}), description="Daftar departemen yang tersedia.")
 * },
 * required={"salutationType", "domisiliType", "employeeTaxStatusType", "employeeWorkStatusType", "branch", "departement"}
 * )
 *
 * @OA\Schema(
 * schema="EmployeSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik Karyawan",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus karyawan yang berhasil.",
 * type="object",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Status sukses dari Accurate API."),
 * @OA\Property(property="m", type="string", example="Data berhasil disimpan.", description="Pesan dari Accurate API."),
 * @OA\Property(property="d", type="integer", example=101, description="ID objek yang baru dibuat/diperbarui/dihapus (opsional).", nullable=true)
 * },
 * required={"s", "m"}
 * )
 *
 * @OA\Schema(
 * schema="EmployeDetailResponse",
 * title="Respons Detail Karyawan",
 * description="Struktur respons untuk detail karyawan tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/EmployeData", description="Objek data karyawan.")
 * },
 * required={"success", "status", "data"}
 * )
 *
 * @OA\Schema(
 * schema="EmployeEditResponse",
 * title="Respons Edit Karyawan",
 * description="Struktur respons yang menggabungkan detail karyawan dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/EmployeData", description="Data karyawan yang akan diedit."),
 * @OA\Property(property="form_attribute", ref="#/components/schemas/EmployeFormAttributesResponse", description="Atribut form untuk pengeditan.")
 * },
 * required={"data_edit", "form_attribute"}
 * )
 */
class EmployeSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
