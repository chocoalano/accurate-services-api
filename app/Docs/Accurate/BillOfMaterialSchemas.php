<?php

namespace App\Docs\Accurate;

/**
 * --- NESTED SCHEMAS FOR BOM INPUT & DATA ---
 *
 * @OA\Schema(
 * schema="BomDetailCommonFields",
 * title="Fields Umum Detail BOM",
 * description="Properti umum untuk detail Expense, Material, dan Extra Finish Good dalam BOM.",
 * type="object",
 * properties={
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Classification 1"),
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
 * @OA\Property(property="detailName", type="string", nullable=true, example="Nama Detail"),
 * @OA\Property(property="detailNotes", type="string", nullable=true, example="Catatan tambahan."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="itemUnitName", type="string", nullable=true, example="PCS"),
 * @OA\Property(property="processCategoryName", type="string", nullable=true, example="Proses A"),
 * @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-001"),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus).")
 * }
 * )
 *
 * @OA\Schema(
 * schema="BomDetailExpenseItem",
 * title="Item Detail Biaya BOM",
 * description="Detail biaya dalam Bill of Material.",
 * type="object",
 * allOf={
 * @OA\Schema(ref="#/components/schemas/BomDetailCommonFields")
 * },
 * properties={
 * @OA\Property(property="itemNo", type="string", example="EXP-001", description="Nomor item biaya."),
 * @OA\Property(property="quantity", type="number", format="double", example=10.5, description="Kuantitas biaya.")
 * },
 * required={"itemNo", "quantity"}
 * )
 *
 * @OA\Schema(
 * schema="BomDetailMaterialItem",
 * title="Item Detail Material BOM",
 * description="Detail material dalam Bill of Material.",
 * type="object",
 * allOf={
 * @OA\Schema(ref="#/components/schemas/BomDetailCommonFields")
 * },
 * properties={
 * @OA\Property(property="itemNo", type="string", example="RAW-001", description="Nomor item material."),
 * @OA\Property(property="quantity", type="number", format="double", example=50, description="Kuantitas material.")
 * },
 * required={"itemNo", "quantity"}
 * )
 *
 * @OA\Schema(
 * schema="BomDetailExtraFinishGoodItem",
 * title="Item Detail Hasil Jadi Tambahan BOM",
 * description="Detail produk hasil jadi tambahan dalam Bill of Material.",
 * type="object",
 * allOf={
 * @OA\Schema(ref="#/components/schemas/BomDetailCommonFields")
 * },
 * properties={
 * @OA\Property(property="itemNo", type="string", example="FG-EXTRA-001", description="Nomor item hasil jadi tambahan."),
 * @OA\Property(property="quantity", type="number", format="double", example=2.0, description="Kuantitas hasil jadi tambahan."),
 * @OA\Property(property="portion", type="number", format="double", nullable=true, example=0.5, description="Porsi produk jadi tambahan.")
 * },
 * required={"itemNo", "quantity"}
 * )
 *
 * @OA\Schema(
 * schema="BomDetailProcessItem",
 * title="Item Detail Proses BOM",
 * description="Detail proses produksi dalam Bill of Material.",
 * type="object",
 * properties={
 * @OA\Property(property="processCategoryName", type="string", example="Assembly", description="Nama kategori proses."),
 * @OA\Property(property="sortNumber", type="integer", example=1, description="Nomor urut proses."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="instruction", type="string", nullable=true, example="Rakit komponen A dan B."),
 * @OA\Property(property="subCon", type="boolean", nullable=true, example=false, description="Menunjukkan apakah ini subkontraktor."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus).")
 * },
 * required={"processCategoryName", "sortNumber"}
 * )
 *
 * @OA\Schema(
 * schema="BomSecondQualityProductItem",
 * title="Item Produk Kualitas Kedua BOM",
 * description="Item produk kualitas kedua dalam Bill of Material.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="number", type="string", example="SQP-001"),
 * @OA\Property(property="name", type="string", example="Produk QC Reject")
 * }
 * )
 *
 * --- MAIN SCHEMAS ---
 *
 * @OA\Schema(
 * schema="BillOfMaterialInput",
 * title="Input Bill of Material",
 * description="Skema untuk data input saat membuat atau memperbarui Bill of Material.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, description="ID unik BOM. Diperlukan untuk update."),
 * @OA\Property(property="itemNo", type="string", example="FG-001", description="Nomor item hasil jadi (Finish Good)."),
 * @OA\Property(property="quantity", type="number", format="double", example=100.0, description="Kuantitas hasil jadi yang diproduksi."),
 * @OA\Property(property="transDate", type="string", format="date", example="31/03/2016", description="Tanggal transaksi BOM (DD/MM/YYYY)."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=1, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Deskripsi BOM untuk produk X."),
 * @OA\Property(property="itemUnitName", type="string", nullable=true, example="Unit"),
 * @OA\Property(property="number", type="string", nullable=true, example="BOM-001", description="Nomor dokumen BOM."),
 * @OA\Property(property="secondQualityProductNo", type="array", nullable=true, @OA\Items(type="string"), example={"SQP-001"}, description="Daftar nomor produk kualitas kedua terkait."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="Tipe nomor otomatis."),
 * @OA\Property(property="detailExpense", type="array", nullable=true, @OA\Items(ref="#/components/schemas/BomDetailExpenseItem"), description="Detail daftar biaya."),
 * @OA\Property(property="detailMaterial", type="array", nullable=true, @OA\Items(ref="#/components/schemas/BomDetailMaterialItem"), description="Detail daftar material."),
 * @OA\Property(property="detailExtraFinishGood", type="array", nullable=true, @OA\Items(ref="#/components/schemas/BomDetailExtraFinishGoodItem"), description="Detail daftar hasil jadi tambahan."),
 * @OA\Property(property="detailProcess", type="array", nullable=true, @OA\Items(ref="#/components/schemas/BomDetailProcessItem"), description="Detail daftar proses.")
 * },
 * required={"itemNo", "quantity", "transDate"}
 * )
 *
 * @OA\Schema(
 * schema="BillOfMaterialData",
 * title="Detail Data Bill of Material",
 * description="Representasi lengkap data satu Bill of Material dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=101, description="ID unik internal BOM."),
 * @OA\Property(property="number", type="string", example="BOM-2024-001", description="Nomor dokumen BOM."),
 * @OA\Property(property="transDate", type="string", example="20/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="itemNo", type="string", example="PROD-A", description="Nomor item utama yang diproduksi."),
 * @OA\Property(property="itemName", type="string", example="Produk Jadi A", description="Nama item utama."),
 * @OA\Property(property="quantity", type="number", format="double", example=100.0, description="Kuantitas item utama yang diproduksi."),
 * @OA\Property(property="itemUnitName", type="string", example="PCS", description="Unit item utama."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=50, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Kantor Pusat", description="Nama cabang."),
 * @OA\Property(property="description", type="string", nullable=true, example="BOM untuk produksi batch bulan ini."),
 * @OA\Property(property="suspended", type="boolean", example=false, description="Status penangguhan BOM."),
 * @OA\Property(property="detailMaterial", type="array", @OA\Items(type="object"), description="Daftar detail material (skema lengkap bisa berbeda)."),
 * @OA\Property(property="detailExpense", type="array", @OA\Items(type="object"), description="Daftar detail biaya (skema lengkap bisa berbeda)."),
 * @OA\Property(property="detailProcess", type="array", @OA\Items(type="object"), description="Daftar detail proses (skema lengkap bisa berbeda)."),
 * @OA\Property(property="detailExtraFinishGood", type="array", @OA\Items(type="object"), description="Daftar detail hasil jadi tambahan (skema lengkap bisa berbeda)."),
 * @OA\Property(property="secondQualityProductNo", type="array", @OA\Items(type="string"), nullable=true, example={"SQP-001"}, description="Daftar nomor produk kualitas kedua terkait."),
 * @OA\Property(property="optLock", type="integer", example=1),
 * @OA\Property(property="createDate", type="string", format="date-time", example="2024-06-20 10:00:00"),
 * @OA\Property(property="lastUpdate", type="string", format="date-time", example="2024-06-20 11:30:00")
 * },
 * required={"id", "number", "transDate", "itemNo", "quantity", "itemUnitName"}
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="BillOfMaterialListResponse",
 * title="Respons Daftar Bill of Material",
 * description="Struktur respons untuk daftar Bill of Material dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/BillOfMaterialData"), description="Array daftar objek Bill of Material."),
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
 * schema="BillOfMaterialSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik BOM",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus BOM yang berhasil.",
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
 * schema="BillOfMaterialDetailResponse",
 * title="Respons Detail Bill of Material",
 * description="Struktur respons untuk detail Bill of Material tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/BillOfMaterialData", description="Objek data Bill of Material.")
 * },
 * required={"success", "status", "data"}
 * )
 *
 * @OA\Schema(
 * schema="BillOfMaterialEditResponse",
 * title="Respons Edit Bill of Material",
 * description="Struktur respons yang menggabungkan detail Bill of Material dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/BillOfMaterialData", description="Data Bill of Material yang akan diedit."),
 * @OA\Property(property="form_attribute", type="object", description="Atribut form untuk pengeditan (kosong untuk BOM).", example={})
 * },
 * required={"data_edit", "form_attribute"}
 * )
 */
class BillOfMaterialSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
