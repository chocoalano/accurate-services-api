<?php

namespace App\Docs\Accurate;

/**
 * --- VENDOR (SUPPLIER) DATA SCHEMAS ---
 *
 * Skema ini disesuaikan dengan bentuk payload/respons dari SupplierController.
 * Jika Anda menambah field tambahan (NPWP, term pembayaran, kontak PIC, dsb.),
 * cukup extend VendorData & VendorInput.
 */

/**
 * Data vendor tunggal (detail).
 *
 * @OA\Schema(
 *   schema="VendorData",
 *   title="Detail Data Vendor",
 *   description="Representasi data satu vendor (pemasok) dari Accurate.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="id", type="integer", example=501, description="ID internal vendor di Accurate."),
 *     @OA\Property(property="name", type="string", example="PT Sumber Bahan Makmur", description="Nama vendor."),
 *     @OA\Property(property="code", type="string", nullable=true, example="VND-0001", description="Kode vendor."),
 *     @OA\Property(property="phone", type="string", nullable=true, example="021-555-1234", description="Nomor telepon vendor."),
 *     @OA\Property(property="email", type="string", nullable=true, example="purchasing@sumberbahan.co.id", description="Email vendor."),
 *     @OA\Property(property="address", type="string", nullable=true, example="Jl. Industri No. 1, Jakarta", description="Alamat vendor."),
 *     @OA\Property(property="isActive", type="boolean", example=true, description="Status aktif/tidak aktif vendor.")
 *   },
 *   required={"id","name"}
 * )
 */

/**
 * Payload input saat create/update vendor.
 *
 * @OA\Schema(
 *   schema="VendorInput",
 *   title="Input Data Vendor",
 *   description="Skema data input untuk membuat atau memperbarui vendor. 'id' opsional untuk create, wajib untuk update.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="id", type="integer", nullable=true, description="ID internal vendor. Diperlukan saat update."),
 *     @OA\Property(property="name", type="string", maxLength=255, example="PT Sumber Bahan Makmur", description="Nama vendor. Wajib."),
 *     @OA\Property(property="code", type="string", maxLength=100, nullable=true, example="VND-0001", description="Kode vendor (opsional)."),
 *     @OA\Property(property="phone", type="string", maxLength=50, nullable=true, example="021-555-1234", description="Telepon vendor (opsional)."),
 *     @OA\Property(property="email", type="string", maxLength=255, nullable=true, example="purchasing@sumberbahan.co.id", description="Email vendor (opsional)."),
 *     @OA\Property(property="address", type="string", maxLength=1000, nullable=true, example="Jl. Industri No. 1, Jakarta", description="Alamat vendor (opsional)."),
 *     @OA\Property(property="isActive", type="boolean", nullable=true, example=true, description="Status aktif (opsional).")
 *   },
 *   required={"name"}
 * )
 */

/**
 * Objek meta untuk paginasi.
 *
 * @OA\Schema(
 *   schema="VendorListMeta",
 *   title="Meta Paginasi Vendor",
 *   description="Informasi paginasi untuk daftar vendor.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="page", type="integer", example=1),
 *     @OA\Property(property="pageSize", type="integer", example=50),
 *     @OA\Property(property="total", type="integer", nullable=true, example=240)
 *   },
 *   required={"page","pageSize"}
 * )
 */

/**
 * Respons daftar vendor (GET /supplier).
 *
 * @OA\Schema(
 *   schema="VendorListResponse",
 *   title="Respons Daftar Vendor",
 *   description="Struktur respons untuk endpoint daftar vendor.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true, description="Apakah permintaan berhasil."),
 *     @OA\Property(
 *       property="data",
 *       type="array",
 *       @OA\Items(ref="#/components/schemas/VendorData"),
 *       description="Array data vendor."
 *     ),
 *     @OA\Property(property="meta", ref="#/components/schemas/VendorListMeta", description="Informasi paginasi.")
 *   },
 *   required={"success","data","meta"}
 * )
 */

/**
 * Respons create/update vendor (POST/PUT /supplier).
 * Mengikuti bentuk dari controller: { success, message, data }
 *
 * @OA\Schema(
 *   schema="VendorSaveResponse",
 *   title="Respons Simpan/Update Vendor",
 *   description="Struktur respons saat menyimpan atau memperbarui vendor.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Created"),
 *     @OA\Property(property="data", oneOf={
 *       @OA\Schema(ref="#/components/schemas/VendorData"),
 *       @OA\Schema(type="null")
 *     }, description="Objek vendor yang tersimpan/diperbarui. Bisa null jika API Accurate tidak mengembalikan detail.")
 *   },
 *   required={"success","message"}
 * )
 */

/**
 * Respons detail vendor (GET /supplier/{id}).
 * Controller mengembalikan objek vendor langsung, jadi kita gunakan VendorData.
 *
 * @OA\Schema(
 *   schema="VendorDetailResponse",
 *   title="Respons Detail Vendor",
 *   description="Objek vendor tunggal sebagaimana dikembalikan oleh endpoint detail.",
 *   allOf={
 *     @OA\Schema(ref="#/components/schemas/VendorData")
 *   }
 * )
 */

/**
 * Respons hapus vendor (DELETE /supplier/{id}).
 * Mengikuti bentuk dari controller: { success, message }
 *
 * @OA\Schema(
 *   schema="VendorDeleteResponse",
 *   title="Respons Hapus Vendor",
 *   description="Struktur respons saat menghapus vendor.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Data berhasil dihapus.")
 *   },
 *   required={"success","message"}
 * )
 */
class VendorSchemas
{
    // Kelas penampung anotasi skema (tanpa kode eksekusi)
}
