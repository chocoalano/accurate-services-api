<?php

namespace App\Docs\Accurate\Product;

/**
 * --- ITEM CATEGORY (KATEGORI ITEM) SCHEMAS ---
 */

/**
 * Data kategori item tunggal (detail).
 *
 * @OA\Schema(
 *   schema="ItemCategoryData",
 *   title="Detail Data Kategori Item",
 *   description="Representasi data satu kategori item dari Accurate.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="id", type="integer", example=101, description="ID internal kategori di Accurate."),
 *     @OA\Property(property="name", type="string", example="BEVERAGE", description="Nama kategori."),
 *     @OA\Property(property="code", type="string", nullable=true, example="CAT-BEV", description="Kode kategori."),
 *     @OA\Property(
 *       property="parent",
 *       type="object",
 *       nullable=true,
 *       description="Induk kategori (jika ada).",
 *       properties={
 *         @OA\Property(property="id", type="integer", example=1, description="ID kategori induk."),
 *         @OA\Property(property="name", type="string", example="PRODUCTS", description="Nama kategori induk.")
 *       }
 *     )
 *   },
 *   required={"id","name"}
 * )
 */

/**
 * Payload input saat create/update kategori item.
 *
 * @OA\Schema(
 *   schema="ItemCategoryInput",
 *   title="Input Data Kategori Item",
 *   description="Skema data input untuk membuat atau memperbarui kategori item. 'id' opsional untuk create, wajib untuk update.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="id", type="integer", nullable=true, description="ID internal kategori. Diperlukan saat update."),
 *     @OA\Property(property="name", type="string", maxLength=255, example="BEVERAGE", description="Nama kategori. Wajib."),
 *     @OA\Property(property="code", type="string", maxLength=100, nullable=true, example="CAT-BEV", description="Kode kategori (opsional)."),
 *     @OA\Property(
 *       property="parent",
 *       type="object",
 *       nullable=true,
 *       description="Induk kategori (opsional).",
 *       properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="PRODUCTS")
 *       }
 *     )
 *   },
 *   required={"name"}
 * )
 */

/**
 * Objek meta untuk paginasi daftar kategori.
 *
 * @OA\Schema(
 *   schema="ItemCategoryListMeta",
 *   title="Meta Paginasi Kategori Item",
 *   description="Informasi paginasi untuk daftar kategori item.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="page", type="integer", example=1),
 *     @OA\Property(property="pageSize", type="integer", example=50),
 *     @OA\Property(property="total", type="integer", nullable=true, example=137)
 *   },
 *   required={"page","pageSize"}
 * )
 */

/**
 * Respons daftar kategori item (GET /product/item-categories).
 *
 * @OA\Schema(
 *   schema="ItemCategoryListResponse",
 *   title="Respons Daftar Kategori Item",
 *   description="Struktur respons untuk endpoint daftar kategori item.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true, description="Apakah permintaan berhasil."),
 *     @OA\Property(
 *       property="data",
 *       type="array",
 *       @OA\Items(ref="#/components/schemas/ItemCategoryData"),
 *       description="Array data kategori item."
 *     ),
 *     @OA\Property(property="meta", ref="#/components/schemas/ItemCategoryListMeta", description="Informasi paginasi.")
 *   },
 *   required={"success","data","meta"}
 * )
 */

/**
 * Respons create/update kategori item (POST/PUT).
 * Mengikuti controller: { success, message, data }
 *
 * @OA\Schema(
 *   schema="ItemCategorySaveResponse",
 *   title="Respons Simpan/Update Kategori Item",
 *   description="Struktur respons saat menyimpan atau memperbarui kategori item.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Created"),
 *     @OA\Property(property="data", oneOf={
 *       @OA\Schema(ref="#/components/schemas/ItemCategoryData"),
 *       @OA\Schema(type="null")
 *     }, description="Objek kategori hasil simpan/update. Bisa null bila Accurate tidak mengembalikan detail.")
 *   },
 *   required={"success","message"}
 * )
 */

/**
 * Respons detail kategori item (GET /product/item-categories/{id}).
 * Controller mengembalikan objek kategori langsung.
 *
 * @OA\Schema(
 *   schema="ItemCategoryDetailResponse",
 *   title="Respons Detail Kategori Item",
 *   description="Objek kategori item tunggal sebagaimana dikembalikan oleh endpoint detail.",
 *   allOf={
 *     @OA\Schema(ref="#/components/schemas/ItemCategoryData")
 *   }
 * )
 */

/**
 * Respons hapus kategori item (DELETE /product/item-categories/{id}).
 * Mengikuti controller: { success, message }
 *
 * @OA\Schema(
 *   schema="ItemCategoryDeleteResponse",
 *   title="Respons Hapus Kategori Item",
 *   description="Struktur respons saat menghapus kategori item.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Data berhasil dihapus.")
 *   },
 *   required={"success","message"}
 * )
 */
class ItemCataegorySchemas
{
    // Hanya penampung anotasi schema.
}
