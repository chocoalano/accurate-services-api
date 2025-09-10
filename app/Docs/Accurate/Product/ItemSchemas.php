<?php

namespace App\Docs\Accurate\Product;

/**
 * --- ITEM (BARANG & JASA) SCHEMAS - L5 Swagger ---
 *
 * Mencakup:
 * - Item: list/detail/save/delete
 * - Nearest Cost
 * - Selling Price
 * - Stock
 * - Stock Mutation History
 * - Vendor Prices
 */

/**
 * Data item tunggal.
 *
 * @OA\Schema(
 *   schema="ItemData",
 *   title="Detail Data Item",
 *   description="Representasi data satu item dari Accurate.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="id", type="integer", example=101, description="ID internal item di Accurate."),
 *     @OA\Property(property="name", type="string", example="Matcha 1kg", description="Nama item."),
 *     @OA\Property(property="code", type="string", nullable=true, example="SKU-MATCHA-1KG", description="Kode item."),
 *     @OA\Property(property="itemType", type="string", example="INVENTORY", description="Tipe item, contoh INVENTORY atau SERVICE."),
 *     @OA\Property(property="unit", type="string", nullable=true, example="KG", description="Satuan default."),
 *     @OA\Property(property="salesPrice", type="number", format="float", nullable=true, example=125000, description="Harga jual dasar."),
 *     @OA\Property(property="isActive", type="boolean", nullable=true, example=true, description="Status aktif item.")
 *   },
 *   required={"id","name"}
 * )
 */

/**
 * Payload input saat create/update item.
 *
 * @OA\Schema(
 *   schema="ItemInput",
 *   title="Input Data Item",
 *   description="Skema data input untuk membuat atau memperbarui item. 'id' opsional untuk create, wajib untuk update.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="id", type="integer", nullable=true, description="ID internal item. Diperlukan saat update."),
 *     @OA\Property(property="name", type="string", maxLength=255, example="Matcha 1kg", description="Nama item. Wajib."),
 *     @OA\Property(property="code", type="string", maxLength=100, nullable=true, example="SKU-MATCHA-1KG", description="Kode item."),
 *     @OA\Property(property="itemType", type="string", example="INVENTORY", description="Tipe item, misal INVENTORY atau SERVICE."),
 *     @OA\Property(property="unit", type="string", maxLength=50, nullable=true, example="KG", description="Satuan default."),
 *     @OA\Property(property="salesPrice", type="number", format="float", nullable=true, example=125000, description="Harga jual dasar.")
 *   },
 *   required={"name"}
 * )
 */

/**
 * Respons daftar item.
 *
 * @OA\Schema(
 *   schema="ItemListResponse",
 *   title="Respons Daftar Item",
 *   description="Struktur respons untuk endpoint daftar item.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ItemData")),
 *     @OA\Property(
 *       property="meta",
 *       type="object",
 *       properties={
 *         @OA\Property(property="page", type="integer", example=1),
 *         @OA\Property(property="pageSize", type="integer", example=50),
 *         @OA\Property(property="total", type="integer", nullable=true, example=137)
 *       }
 *     )
 *   },
 *   required={"success","data","meta"}
 * )
 */

/**
 * Respons detail item.
 *
 * @OA\Schema(
 *   schema="ItemDetailResponse",
 *   title="Respons Detail Item",
 *   description="Objek item tunggal sebagaimana dikembalikan oleh endpoint detail.",
 *   allOf={ @OA\Schema(ref="#/components/schemas/ItemData") }
 * )
 */

/**
 * Respons simpan/update item.
 *
 * @OA\Schema(
 *   schema="ItemSaveResponse",
 *   title="Respons Simpan/Update Item",
 *   description="Struktur respons saat menyimpan atau memperbarui item.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Created"),
 *     @OA\Property(property="data", oneOf={ @OA\Schema(ref="#/components/schemas/ItemData"), @OA\Schema(type="null") })
 *   },
 *   required={"success","message"}
 * )
 */

/**
 * Respons hapus item.
 *
 * @OA\Schema(
 *   schema="ItemDeleteResponse",
 *   title="Respons Hapus Item",
 *   description="Struktur respons saat menghapus item.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Data berhasil dihapus.")
 *   },
 *   required={"success","message"}
 * )
 */

/**
 * Respons Nearest Cost.
 *
 * @OA\Schema(
 *   schema="ItemNearestCostResponse",
 *   title="Respons Nearest Cost Item",
 *   description="Hasil perhitungan nearest cost untuk item.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="cost", type="number", format="float", example=98765.43),
 *     @OA\Property(property="currency", type="string", example="IDR"),
 *     @OA\Property(property="asOfDate", type="string", format="date", example="2025-09-01"),
 *     @OA\Property(property="warehouseId", type="integer", nullable=true, example=12),
 *     @OA\Property(property="method", type="string", example="nearest")
 *   },
 *   required={"cost"}
 * )
 */

/**
 * Respons Selling Price.
 *
 * @OA\Schema(
 *   schema="ItemSellingPriceResponse",
 *   title="Respons Selling Price Item",
 *   description="Harga jual efektif item berdasarkan parameter yang diberikan.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="price", type="number", format="float", example=125000),
 *     @OA\Property(property="currency", type="string", example="IDR"),
 *     @OA\Property(property="priceCategoryId", type="integer", nullable=true, example=3),
 *     @OA\Property(property="priceCategoryName", type="string", nullable=true, example="Retail"),
 *     @OA\Property(property="customerId", type="integer", nullable=true, example=555),
 *     @OA\Property(property="qty", type="number", format="float", nullable=true, example=10),
 *     @OA\Property(property="asOfDate", type="string", format="date", example="2025-09-01"),
 *     @OA\Property(property="warehouseId", type="integer", nullable=true, example=12),
 *     @OA\Property(property="source", type="string", nullable=true, example="price-category")
 *   },
 *   required={"price","currency"}
 * )
 */

/**
 * Respons Stock.
 *
 * @OA\Schema(
 *   schema="ItemStockResponse",
 *   title="Respons Stok Item",
 *   description="Informasi stok per item, bisa per gudang.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="itemId", type="integer", example=101),
 *     @OA\Property(property="warehouseId", type="integer", nullable=true, example=12),
 *     @OA\Property(property="warehouseName", type="string", nullable=true, example="Gudang Utama"),
 *     @OA\Property(property="stock", type="number", format="float", example=150),
 *     @OA\Property(property="reserved", type="number", format="float", nullable=true, example=20),
 *     @OA\Property(property="available", type="number", format="float", nullable=true, example=130),
 *     @OA\Property(property="asOfDate", type="string", format="date", example="2025-09-10")
 *   },
 *   required={"itemId","stock"}
 * )
 */

/**
 * Satu baris mutasi stok.
 *
 * @OA\Schema(
 *   schema="ItemStockMutationRow",
 *   title="Baris Mutasi Stok Item",
 *   description="Satu record mutasi stok untuk item tertentu.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="date", type="string", format="date", example="2025-09-05"),
 *     @OA\Property(property="warehouseId", type="integer", example=12),
 *     @OA\Property(property="warehouseName", type="string", example="Gudang Utama"),
 *     @OA\Property(property="docType", type="string", example="Sales Delivery"),
 *     @OA\Property(property="docNo", type="string", example="SD-000123"),
 *     @OA\Property(property="reference", type="string", nullable=true, example="Pengiriman 000123"),
 *     @OA\Property(property="qtyIn", type="number", format="float", example=0),
 *     @OA\Property(property="qtyOut", type="number", format="float", example=5),
 *     @OA\Property(property="balance", type="number", format="float", example=125),
 *     @OA\Property(property="remarks", type="string", nullable=true, example="Kirim ke customer A")
 *   },
 *   required={"date","docType"}
 * )
 */

/**
 * Respons daftar riwayat mutasi stok.
 *
 * @OA\Schema(
 *   schema="ItemStockMutationListResponse",
 *   title="Respons Riwayat Mutasi Stok Item",
 *   description="Struktur respons untuk daftar mutasi stok item dengan paginasi.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/ItemStockMutationRow")),
 *     @OA\Property(
 *       property="meta",
 *       type="object",
 *       properties={
 *         @OA\Property(property="page", type="integer", example=1),
 *         @OA\Property(property="pageSize", type="integer", example=50),
 *         @OA\Property(property="total", type="integer", nullable=true, example=240)
 *       }
 *     )
 *   },
 *   required={"success","data","meta"}
 * )
 */

/**
 * Schema baris vendor price (tersedia untuk reuse).
 *
 * @OA\Schema(
 *   schema="ItemVendorPriceRow",
 *   title="Baris Vendor Price Item",
 *   description="Satu record harga vendor untuk item tertentu.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="id", type="integer", example=991122, description="ID internal vendor price."),
 *     @OA\Property(property="itemId", type="integer", example=12345, description="ID item."),
 *     @OA\Property(property="vendorId", type="integer", example=67890, description="ID vendor."),
 *     @OA\Property(property="unit", type="string", example="PCS", description="Satuan harga."),
 *     @OA\Property(property="price", type="number", format="float", example=14500, description="Harga beli dari vendor."),
 *     @OA\Property(property="currency", type="string", example="IDR", description="Mata uang."),
 *     @OA\Property(property="minQty", type="number", format="float", nullable=true, example=1, description="Minimum qty jika ada tier."),
 *     @OA\Property(property="effectiveDate", type="string", format="date", nullable=true, example="2025-09-01", description="Tanggal mulai berlaku."),
 *     @OA\Property(property="expiredDate", type="string", format="date", nullable=true, example="2025-12-31", description="Tanggal berakhir."),
 *     @OA\Property(property="notes", type="string", nullable=true, example="Harga kontrak Q4 2025", description="Catatan tambahan.")
 *   },
 *   required={"id","itemId","vendorId","price","currency"}
 * )
 */

/**
 * Respons daftar vendor price per item.
 *
 * @OA\Schema(
 *   schema="ItemVendorPriceListResponse",
 *   title="Respons Daftar Vendor Price Item",
 *   description="Struktur respons untuk daftar harga vendor per item dengan paginasi.",
 *   type="object",
 *   properties={
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *       property="data",
 *       type="array",
 *       @OA\Items(
 *         type="object",
 *         properties={
 *           @OA\Property(property="id", type="integer", example=991122),
 *           @OA\Property(property="itemId", type="integer", example=12345),
 *           @OA\Property(property="vendorId", type="integer", example=67890),
 *           @OA\Property(property="unit", type="string", example="PCS"),
 *           @OA\Property(property="price", type="number", format="float", example=14500),
 *           @OA\Property(property="currency", type="string", example="IDR"),
 *           @OA\Property(property="minQty", type="number", format="float", nullable=true, example=1),
 *           @OA\Property(property="effectiveDate", type="string", format="date", nullable=true, example="2025-09-01"),
 *           @OA\Property(property="expiredDate", type="string", format="date", nullable=true, example="2025-12-31"),
 *           @OA\Property(property="notes", type="string", nullable=true, example="Harga kontrak Q4 2025")
 *         }
 *       )
 *     ),
 *     @OA\Property(
 *       property="meta",
 *       type="object",
 *       properties={
 *         @OA\Property(property="page", type="integer", example=1),
 *         @OA\Property(property="pageSize", type="integer", example=50),
 *         @OA\Property(property="total", type="integer", nullable=true, example=240)
 *       }
 *     )
 *   },
 *   required={"success","data","meta"}
 * )
 */
final class ItemSchemas
{
    // Penampung anotasi schema.
}
