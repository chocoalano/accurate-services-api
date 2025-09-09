<?php

namespace App\Docs\Accurate;

/**
 * --- NESTED SCHEMAS FOR SALES RETURN INPUT & DATA ---
 *
 * @OA\Schema(
 * schema="SalesReturnDetailExpenseItem",
 * title="Item Detail Biaya Retur Penjualan",
 * description="Detail biaya dalam retur penjualan.",
 * type="object",
 * properties={
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus)."),
 * @OA\Property(property="accountNo", type="string", nullable=true, example="1101-01", description="Nomor akun biaya."),
 * @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Wilayah Barat"),
 * @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Pemasaran"),
 * @OA\Property(property="expenseAmount", type="number", format="double", nullable=true, example=50000.00, description="Jumlah biaya."),
 * @OA\Property(property="expenseName", type="string", nullable=true, example="Biaya Pengiriman Retur"),
 * @OA\Property(property="expenseNotes", type="string", nullable=true, example="Catatan untuk biaya ini."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="salesOrderNumber", type="string", nullable=true, example="SO-RE-001", description="Nomor Sales Order terkait."),
 * @OA\Property(property="salesQuotationNumber", type="string", nullable=true, example="SQ-RE-001", description="Nomor Sales Quotation terkait.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesReturnDetailSerialNumberItem",
 * title="Item Detail Nomor Seri Retur Penjualan",
 * description="Detail nomor seri dalam item retur penjualan.",
 * type="object",
 * properties={
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus)."),
 * @OA\Property(property="expiredDate", type="string", format="date", nullable=true, example="31/12/2024", description="Tanggal kedaluwarsa (DD/MM/YYYY)."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="quantity", type="number", format="double", nullable=true, example=1.0, description="Kuantitas untuk nomor seri ini."),
 * @OA\Property(property="serialNumberNo", type="string", nullable=true, example="SN-RETUR-001", description="Nomor seri.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesReturnDetailItem",
 * title="Item Detail Retur Penjualan",
 * description="Detail item dalam retur penjualan.",
 * type="object",
 * properties={
 * @OA\Property(property="itemNo", type="string", example="ITEM001", description="Nomor item produk. Wajib."),
 * @OA\Property(property="unitPrice", type="number", format="double", example=150000.00, description="Harga satuan item. Wajib."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus)."),
 * @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Kategori A"),
 * @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Penjualan"),
 * @OA\Property(property="detailName", type="string", nullable=true, example="Nama Item Retur"),
 * @OA\Property(property="detailNotes", type="string", nullable=true, example="Catatan tentang item retur."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="itemCashDiscount", type="number", format="double", nullable=true, example=0.00, description="Diskon tunai per item."),
 * @OA\Property(property="itemDiscPercent", type="string", nullable=true, example="0", description="Persentase diskon item."),
 * @OA\Property(property="itemUnitName", type="string", nullable=true, example="PCS"),
 * @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-R-001"),
 * @OA\Property(property="quantity", type="number", format="double", nullable=true, example=5.0, description="Kuantitas item retur."),
 * @OA\Property(property="returnDetailStatusType", type="string", enum={"NOT_RETURNED", "RETURNED"}, nullable=true, example="RETURNED", description="Status detail retur."),
 * @OA\Property(property="useTax1", type="boolean", nullable=true, example=true, description="Gunakan pajak 1."),
 * @OA\Property(property="useTax2", type="boolean", nullable=true, example=false, description="Gunakan pajak 2."),
 * @OA\Property(property="useTax3", type="boolean", nullable=true, example=false, description="Gunakan pajak 3."),
 * @OA\Property(property="warehouseName", type="string", nullable=true, example="Gudang Retur"),
 * @OA\Property(property="detailSerialNumber", type="array", nullable=true, @OA\Items(ref="#/components/schemas/SalesReturnDetailSerialNumberItem"), description="Daftar detail nomor seri.")
 * }
 * )
 *
 * --- MAIN SCHEMAS ---
 *
 * @OA\Schema(
 * schema="SalesReturnInput",
 * title="Input Retur Penjualan",
 * description="Skema lengkap untuk data input saat membuat atau memperbarui retur penjualan.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=101, description="ID unik retur penjualan. Diperlukan untuk operasi update, null/kosong untuk create."),
 * @OA\Property(property="customerNo", type="string", example="CUST-001", description="Nomor pelanggan. Wajib."),
 * @OA\Property(
 * property="returnType",
 * type="string",
 * enum={"DELIVERY", "INVOICE", "INVOICE_DP", "NO_INVOICE"},
 * example="INVOICE",
 * description="Tipe retur. Wajib."
 * ),
 * @OA\Property(property="taxDate", type="string", format="date", example="25/06/2024", description="Tanggal pajak (DD/MM/YYYY). Wajib."),
 * @OA\Property(property="taxNumber", type="string", example="TAX-RETUR-001", description="Nomor faktur pajak. Wajib."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=1, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="cashDiscPercent", type="string", nullable=true, example="0", description="Persentase diskon tunai."),
 * @OA\Property(property="cashDiscount", type="number", format="double", nullable=true, example=0.00, description="Jumlah diskon tunai."),
 * @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR", description="Kode mata uang."),
 * @OA\Property(property="deliveryOrderNumber", type="string", nullable=true, example="DO-001", description="Nomor Delivery Order terkait."),
 * @OA\Property(property="description", type="string", nullable=true, example="Retur produk karena cacat."),
 * @OA\Property(property="fiscalRate", type="number", format="double", nullable=true, example=1.0, description="Kurs fiskal."),
 * @OA\Property(property="fobName", type="string", nullable=true, example="Gudang Retur", description="Nama FOB."),
 * @OA\Property(property="inclusiveTax", type="boolean", nullable=true, example=true, description="Apakah pajak termasuk dalam harga."),
 * @OA\Property(property="invoiceNumber", type="string", nullable=true, example="INV-001", description="Nomor faktur asli yang diretur."),
 * @OA\Property(property="number", type="string", nullable=true, example="RETUR-20240625-001", description="Nomor retur penjualan."),
 * @OA\Property(property="paymentTermName", type="string", nullable=true, example="Cash", description="Nama syarat pembayaran."),
 * @OA\Property(property="rate", type="number", format="double", nullable=true, example=1.0, description="Kurs mata uang."),
 * @OA\Property(
 * property="returnStatusType",
 * type="string",
 * enum={"NOT_RETURNED", "PARTIALLY_RETURNED", "RETURNED"},
 * nullable=true,
 * example="RETURNED",
 * description="Status retur penjualan."
 * ),
 * @OA\Property(property="shipmentName", type="string", nullable=true, example="Kurir Cepat", description="Nama ekspedisi/pengiriman."),
 * @OA\Property(property="taxable", type="boolean", nullable=true, example=true, description="Apakah dikenakan pajak."),
 * @OA\Property(property="toAddress", type="string", nullable=true, example="Alamat Retur", description="Alamat pengiriman retur."),
 * @OA\Property(property="transDate", type="string", format="date", nullable=true, example="25/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="Tipe penomoran otomatis."),
 * @OA\Property(property="detailExpense", type="array", nullable=true, @OA\Items(ref="#/components/schemas/SalesReturnDetailExpenseItem"), description="Daftar detail biaya."),
 * @OA\Property(property="detailItem", type="array", nullable=true, @OA\Items(ref="#/components/schemas/SalesReturnDetailItem"), description="Daftar detail item retur.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesReturnData",
 * title="Detail Data Retur Penjualan",
 * description="Representasi lengkap data satu retur penjualan dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=101, description="ID unik internal retur."),
 * @OA\Property(property="number", type="string", example="RETUR-20240625-001", description="Nomor retur penjualan."),
 * @OA\Property(property="transDate", type="string", example="25/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="customerName", type="string", example="PT Contoh Jaya", description="Nama pelanggan."),
 * @OA\Property(property="totalAmount", type="number", format="double", example=750000.00, description="Total jumlah retur."),
 * @OA\Property(property="returnType", type="string", example="INVOICE", description="Tipe retur."),
 * @OA\Property(property="taxNumber", type="string", example="TAX-RETUR-001", description="Nomor faktur pajak."),
 * @OA\Property(property="description", type="string", nullable=true, example="Retur sebagian karena kesalahan pengiriman."),
 * @OA\Property(property="currencyCode", type="string", example="IDR", description="Kode mata uang."),
 * @OA\Property(property="status", type="string", example="RETURNED", description="Status retur."),
 * @OA\Property(property="detailItem", type="array", @OA\Items(type="object"), description="Daftar item retur."),
 * @OA\Property(property="detailExpense", type="array", @OA\Items(type="object"), description="Daftar biaya retur.")
 * },
 * required={"id", "number", "transDate", "customerName", "totalAmount", "returnType", "taxNumber"}
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="SalesReturnListResponse",
 * title="Respons Daftar Retur Penjualan",
 * description="Struktur respons untuk daftar retur penjualan dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/SalesReturnData"), description="Array daftar objek retur penjualan."),
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
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesReturnSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik Retur Penjualan",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus retur penjualan yang berhasil.",
 * type="object",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Status sukses dari Accurate API."),
 * @OA\Property(property="m", type="string", example="Data berhasil disimpan.", description="Pesan dari Accurate API."),
 * @OA\Property(property="d", type="integer", example=101, description="ID objek yang baru dibuat/diperbarui/dihapus (opsional).", nullable=true)
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesReturnDetailResponse",
 * title="Respons Detail Retur Penjualan",
 * description="Struktur respons untuk detail retur penjualan tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/SalesReturnData", description="Objek data retur penjualan.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesReturnEditResponse",
 * title="Respons Edit Retur Penjualan",
 * description="Struktur respons yang menggabungkan detail retur penjualan dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/SalesReturnData", description="Data retur penjualan yang akan diedit."),
 * @OA\Property(property="form_attribute", type="object", description="Atribut form untuk pengeditan.",
 * properties={
 * @OA\Property(property="returnType", type="array", @OA\Items(type="string", enum={"DELIVERY", "INVOICE", "INVOICE_DP", "NO_INVOICE"}), description="Opsi tipe retur."),
 * @OA\Property(property="statusType", type="array", @OA\Items(type="string", enum={"NOT_RETURNED", "PARTIALLY_RETURNED", "RETURNED"}), description="Opsi status retur."),
 * @OA\Property(property="statusTypeItem", type="array", @OA\Items(type="string", enum={"NOT_RETURNED", "RETURNED"}), description="Opsi status item retur.")
 * }
 * )
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesReturnDetailReturnResponse",
 * title="Respons Detail Retur Pelanggan",
 * description="Struktur respons untuk daftar retur pelanggan berdasarkan nomor pelanggan.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/SalesReturnData"), description="Daftar retur yang terkait dengan pelanggan.")
 * }
 * )
 */
class SalesReturnSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
