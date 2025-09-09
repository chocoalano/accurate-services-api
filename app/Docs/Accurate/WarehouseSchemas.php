<?php

namespace App\Docs\Accurate;

/**
 * --- MAIN DATA SCHEMAS ---
 *
 * @OA\Schema(
 * schema="WarehouseData",
 * title="Detail Data Gudang",
 * description="Representasi lengkap data satu gudang dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=101, description="ID unik internal gudang."),
 * @OA\Property(property="name", type="string", example="Gudang Utama Jakarta", description="Nama gudang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Gudang utama untuk distribusi di wilayah Jakarta.", description="Deskripsi gudang."),
 * @OA\Property(property="city", type="string", nullable=true, example="Jakarta", description="Kota lokasi gudang."),
 * @OA\Property(property="country", type="string", nullable=true, example="Indonesia", description="Negara lokasi gudang."),
 * @OA\Property(property="province", type="string", nullable=true, example="DKI Jakarta", description="Provinsi lokasi gudang."),
 * @OA\Property(property="street", type="string", nullable=true, example="Jl. Raya Bogor No. 123", description="Jalan lokasi gudang."),
 * @OA\Property(property="zipCode", type="string", nullable=true, example="13710", description="Kode pos lokasi gudang."),
 * @OA\Property(property="pic", type="string", nullable=true, example="Budi Santoso", description="Nama penanggung jawab gudang."),
 * @OA\Property(property="scrapWarehouse", type="boolean", example=false, description="Menunjukkan apakah ini gudang barang rongsok/rusak."),
 * @OA\Property(property="suspended", type="boolean", example=false, description="Status penangguhan gudang."),
 * @OA\Property(property="optLock", type="integer", example=1, description="Optimistic lock version."),
 * @OA\Property(property="createDate", type="string", format="date-time", example="2025-06-25 10:00:00", description="Tanggal dan waktu pembuatan gudang."),
 * @OA\Property(property="lastUpdate", type="string", format="date-time", example="2025-06-25 11:30:00", description="Tanggal dan waktu pembaruan terakhir.")
 * },
 * required={"id", "name", "suspended", "scrapWarehouse", "optLock"}
 * )
 *
 * @OA\Schema(
 * schema="WarehouseInput",
 * title="Input Data Gudang",
 * description="Skema untuk data input saat membuat atau memperbarui gudang. 'id' bersifat opsional untuk buat, wajib untuk update.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, description="ID unik internal gudang. Diperlukan untuk operasi update, null/kosong untuk create."),
 * @OA\Property(property="name", type="string", maxLength=255, example="Gudang Barat", description="Nama gudang. Wajib."),
 * @OA\Property(property="city", type="string", maxLength=255, nullable=true, example="Bandung", description="Kota lokasi gudang."),
 * @OA\Property(property="country", type="string", maxLength=255, nullable=true, example="Indonesia", description="Negara lokasi gudang."),
 * @OA\Property(property="description", type="string", maxLength=1000, nullable=true, example="Gudang distribusi regional.", description="Deskripsi gudang."),
 * @OA\Property(property="pic", type="string", maxLength=255, nullable=true, example="Ani Mardani", description="Nama penanggung jawab gudang."),
 * @OA\Property(property="province", type="string", maxLength=255, nullable=true, example="Jawa Barat", description="Provinsi lokasi gudang."),
 * @OA\Property(property="scrapWarehouse", type="boolean", nullable=true, example=false, description="Menunjukkan apakah ini gudang barang rongsok/rusak."),
 * @OA\Property(property="street", type="string", maxLength=255, nullable=true, example="Jl. Setiabudi No. 50", description="Jalan lokasi gudang."),
 * @OA\Property(property="suspended", type="boolean", nullable=true, example=false, description="Status penangguhan gudang."),
 * @OA\Property(property="zipCode", type="string", maxLength=20, nullable=true, example="40141", description="Kode pos lokasi gudang.")
 * },
 * required={"name"}
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="WarehouseListResponse",
 * title="Respons Daftar Gudang",
 * description="Struktur respons untuk daftar gudang dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/WarehouseData"), description="Array daftar objek gudang."),
 * @OA\Property(property="sp", type="object", description="Informasi paginasi",
 * properties={
 * @OA\Property(property="page", type="integer", example=1),
 * @OA\Property(property="pageSize", type="integer", example=50),
 * @OA\Property(property="pageCount", type="integer", example=1),
 * @OA\Property(property="rowCount", type="integer", example=2),
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
 * schema="WarehouseSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik untuk Gudang",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus gudang yang berhasil.",
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
 * schema="WarehouseDetailResponse",
 * title="Respons Detail Gudang",
 * description="Struktur respons untuk detail gudang tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/WarehouseData", description="Objek data gudang.")
 * },
 * required={"success", "status", "data"}
 * )
 *
 * @OA\Schema(
 * schema="WarehouseEditResponse",
 * title="Respons Edit Gudang",
 * description="Struktur respons yang menggabungkan detail gudang dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/WarehouseData", description="Data gudang yang akan diedit."),
 * @OA\Property(property="form_attribute", type="object", description="Atribut form untuk pengeditan (kosong untuk gudang).", example={})
 * },
 * required={"data_edit", "form_attribute"}
 * )
 */
class WarehouseSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
