<?php

namespace App\Docs\Accurate;

/**
 * @OA\Schema(
 * schema="BranchData",
 * title="Detail Data Cabang",
 * description="Representasi lengkap data satu cabang dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="defaultBranch", type="boolean", example=true, description="Menunjukkan apakah ini cabang default."),
 * @OA\Property(property="name", type="string", example="Kantor Pusat", description="Nama cabang."),
 * @OA\Property(property="id", type="integer", example=50, description="ID unik internal cabang."),
 * @OA\Property(property="suspended", type="boolean", example=false, description="Status penangguhan cabang."),
 * @OA\Property(property="city", type="string", nullable=true, example="Jakarta", description="Kota lokasi cabang."),
 * @OA\Property(property="country", type="string", nullable=true, example="Indonesia", description="Negara lokasi cabang."),
 * @OA\Property(property="province", type="string", nullable=true, example="DKI Jakarta", description="Provinsi lokasi cabang."),
 * @OA\Property(property="street", type="string", nullable=true, example="Jl. Sudirman No. 1", description="Jalan lokasi cabang."),
 * @OA\Property(property="zipCode", type="string", nullable=true, example="10220", description="Kode pos lokasi cabang."),
 * @OA\Property(property="optLock", type="integer", example=0, description="Optimistic lock version."),
 * @OA\Property(property="email", type="string", format="email", nullable=true, example="kantor.pusat@example.com", description="Email cabang."),
 * @OA\Property(property="fax", type="string", nullable=true, example="021-12345678", description="Nomor fax cabang."),
 * @OA\Property(property="mobilePhone", type="string", nullable=true, example="+6281122334455", description="Nomor telepon seluler cabang."),
 * @OA\Property(property="phone", type="string", nullable=true, example="021-98765432", description="Nomor telepon cabang."),
 * @OA\Property(property="website", type="string", format="url", nullable=true, example="http://www.accurate.id", description="Situs web cabang.")
 * },
 * required={"defaultBranch", "name", "id", "suspended"}
 * )
 *
 * @OA\Schema(
 * schema="BranchInput",
 * title="Input Data Cabang",
 * description="Skema untuk data input saat membuat atau memperbarui cabang.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, description="ID unik internal cabang. Diperlukan untuk operasi update, null/kosong untuk create."),
 * @OA\Property(property="name", type="string", example="Cabang Baru", description="Nama cabang. Wajib."),
 * @OA\Property(property="city", type="string", nullable=true, example="Surabaya", description="Kota lokasi cabang."),
 * @OA\Property(property="country", type="string", nullable=true, example="Indonesia", description="Negara lokasi cabang."),
 * @OA\Property(property="province", type="string", nullable=true, example="Jawa Timur", description="Provinsi lokasi cabang."),
 * @OA\Property(property="street", type="string", nullable=true, example="Jl. Pahlawan No. 5", description="Jalan lokasi cabang."),
 * @OA\Property(property="zipCode", type="string", nullable=true, example="60174", description="Kode pos lokasi cabang.")
 * },
 * required={"name"}
 * )
 *
 * @OA\Schema(
 * schema="BranchListResponse",
 * title="Respons Daftar Cabang",
 * description="Struktur respons untuk daftar cabang dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/BranchData"), description="Array daftar objek cabang."),
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
 * schema="BranchSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik untuk Cabang",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus yang berhasil.",
 * type="object",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Status sukses dari Accurate API."),
 * @OA\Property(property="m", type="string", example="Data berhasil disimpan.", description="Pesan dari Accurate API."),
 * @OA\Property(property="d", type="integer", example=51, description="ID objek yang baru dibuat/diperbarui/dihapus (opsional).", nullable=true)
 * },
 * required={"s", "m"}
 * )
 *
 * @OA\Schema(
 * schema="BranchDetailResponse",
 * title="Respons Detail Cabang",
 * description="Struktur respons untuk detail cabang tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/BranchData", description="Objek data cabang.")
 * },
 * required={"success", "status", "data"}
 * )
 *
 * @OA\Schema(
 * schema="BranchEditResponse",
 * title="Respons Edit Cabang",
 * description="Struktur respons yang menggabungkan detail cabang dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/BranchData", description="Data cabang yang akan diedit."),
 * @OA\Property(property="form_attribute", type="object", description="Atribut form untuk pengeditan (kosong untuk cabang).", example={})
 * },
 * required={"data_edit", "form_attribute"}
 * )
 */
class BranchSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
