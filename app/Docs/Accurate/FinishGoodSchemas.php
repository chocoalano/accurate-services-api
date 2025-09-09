<?php

namespace App\Docs\Accurate;

/**
 * --- NESTED SCHEMAS FOR FINISH GOOD SLIP INPUT & DATA ---
 *
 * @OA\Schema(
 * schema="FgsDetailItemCommonFields",
 * title="Fields Umum Detail Item FGS",
 * description="Properti umum untuk detail item dalam Finish Good Slip.",
 * type="object",
 * properties={
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Kategori A"),
 * @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Produksi"),
 * @OA\Property(property="detailName", type="string", nullable=true, example="Nama Item Detail"),
 * @OA\Property(property="detailNotes", type="string", nullable=true, example="Catatan untuk item ini."),
 * @OA\Property(property="itemUnitName", type="string", nullable=true, example="PCS"),
 * @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-FG-001"),
 * @OA\Property(property="warehouseName", type="string", nullable=true, example="Gudang Utama"),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus).")
 * }
 * )
 *
 * @OA\Schema(
 * schema="FgsDetailSerialNumberItem",
 * title="Item Detail Nomor Seri FGS",
 * description="Detail nomor seri untuk setiap item dalam Finish Good Slip.",
 * type="object",
 * properties={
 * @OA\Property(property="expiredDate", type="string", format="date", nullable=true, example="31/12/2025", description="Tanggal kedaluwarsa nomor seri (DD/MM/YYYY)."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="quantity", type="number", format="double", example=1, description="Kuantitas untuk nomor seri ini."),
 * @OA\Property(property="serialNumberNo", type="string", nullable=true, example="SN-FG-001-A", description="Nomor seri unik."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk nomor seri (misal: 'delete' untuk menghapus).")
 * }
 * )
 *
 * @OA\Schema(
 * schema="FgsDetailItem",
 * title="Item Detail Finish Good Slip",
 * description="Detail item produk dalam Finish Good Slip.",
 * type="object",
 * allOf={
 * @OA\Schema(ref="#/components/schemas/FgsDetailItemCommonFields")
 * },
 * properties={
 * @OA\Property(property="itemNo", type="string", example="PROD-FG-001", description="Nomor item produk jadi."),
 * @OA\Property(property="portion", type="number", format="double", example=1.0, description="Porsi item."),
 * @OA\Property(property="quantity", type="number", format="double", example=50.0, description="Kuantitas item produk jadi."),
 * @OA\Property(property="warehouseId", type="integer", example=101, description="ID gudang item ini."),
 * @OA\Property(property="detailSerialNumber", type="array", nullable=true, @OA\Items(ref="#/components/schemas/FgsDetailSerialNumberItem"), description="Daftar nomor seri untuk item ini.")
 * },
 * required={"itemNo", "portion", "quantity", "warehouseId"}
 * )
 *
 * --- MAIN SCHEMAS ---
 *
 * @OA\Schema(
 * schema="FinishGoodSlipInput",
 * title="Input Finish Good Slip",
 * description="Skema untuk data input saat membuat atau memperbarui Finish Good Slip.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, description="ID unik Finish Good Slip. Diperlukan untuk update."),
 * @OA\Property(property="branchId", type="integer", example=1, description="ID cabang terkait."),
 * @OA\Property(property="transDate", type="string", format="date", example="25/06/2024", description="Tanggal transaksi Finish Good Slip (DD/MM/YYYY)."),
 * @OA\Property(property="workOrderNumber", type="string", example="WO-2024-001", description="Nomor Work Order terkait."),
 * @OA\Property(property="detailItem", type="array", @OA\Items(ref="#/components/schemas/FgsDetailItem"), description="Daftar detail item yang diproduksi."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Penyelesaian Work Order bulan Juni."),
 * @OA\Property(property="number", type="string", nullable=true, example="FGS-001", description="Nomor dokumen Finish Good Slip."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="Tipe nomor otomatis.")
 * },
 * required={"branchId", "transDate", "workOrderNumber", "detailItem"}
 * )
 *
 * @OA\Schema(
 * schema="FinishGoodSlipData",
 * title="Detail Data Finish Good Slip",
 * description="Representasi lengkap data satu Finish Good Slip dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=201, description="ID unik internal Finish Good Slip."),
 * @OA\Property(property="number", type="string", example="FGS-20240625-001", description="Nomor dokumen Finish Good Slip."),
 * @OA\Property(property="transDate", type="string", example="25/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="workOrderNumber", type="string", example="WO-2024-001", description="Nomor Work Order terkait."),
 * @OA\Property(property="branchId", type="integer", example=1, description="ID cabang."),
 * @OA\Property(property="branchName", type="string", example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Penyelesaian WO batch 1."),
 * @OA\Property(property="detailItem", type="array", @OA\Items(type="object"), description="Daftar detail item (skema lengkap bisa berbeda)."),
 * @OA\Property(property="optLock", type="integer", example=1),
 * @OA\Property(property="createDate", type="string", format="date-time", example="2024-06-25 09:00:00"),
 * @OA\Property(property="lastUpdate", type="string", format="date-time", example="2024-06-25 10:30:00")
 * },
 * required={"id", "number", "transDate", "workOrderNumber", "branchId", "detailItem"}
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="FinishGoodSlipListResponse",
 * title="Respons Daftar Finish Good Slip",
 * description="Struktur respons untuk daftar Finish Good Slip dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/FinishGoodSlipData"), description="Array daftar objek Finish Good Slip."),
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
 * schema="FinishGoodSlipSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik FGS",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus FGS yang berhasil.",
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
 * schema="FinishGoodSlipDetailResponse",
 * title="Respons Detail Finish Good Slip",
 * description="Struktur respons untuk detail Finish Good Slip tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/FinishGoodSlipData", description="Objek data Finish Good Slip.")
 * },
 * required={"success", "status", "data"}
 * )
 *
 * @OA\Schema(
 * schema="FinishGoodSlipEditResponse",
 * title="Respons Edit Finish Good Slip",
 * description="Struktur respons yang menggabungkan detail Finish Good Slip dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/FinishGoodSlipData", description="Data Finish Good Slip yang akan diedit."),
 * @OA\Property(property="form_attribute", type="object", description="Atribut form untuk pengeditan (kosong untuk FGS).", example={})
 * },
 * required={"data_edit", "form_attribute"}
 * )
 */
class FinishGoodSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
