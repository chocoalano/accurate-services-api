<?php

namespace App\Docs\Accurate\Purchase;

/**
 * --- NESTED SCHEMAS FOR PURCHASE ORDER INPUT & DATA ---
 *
 * @OA\Schema(
 * schema="PurchaseOrderDetailExpenseItem",
 * title="Item Detail Biaya Pesanan Pembelian",
 * description="Detail biaya dalam pesanan pembelian.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=1, description="ID unik item biaya."),
 * @OA\Property(property="accountNo", type="string", nullable=true, example="5001-01", description="Nomor akun biaya."),
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Pusat"),
 * @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Pembelian"),
 * @OA\Property(property="expenseAmount", type="number", format="double", example=50000.00, description="Jumlah biaya."),
 * @OA\Property(property="expenseName", type="string", nullable=true, example="Biaya Pengiriman"),
 * @OA\Property(property="expenseNotes", type="string", nullable=true, example="Ongkir dari supplier."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus).")
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseOrderDetailItem",
 * title="Item Detail Pesanan Pembelian",
 * description="Detail item dalam pesanan pembelian.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=1, description="ID unik item."),
 * @OA\Property(property="itemNo", type="string", example="RAW-001", description="Nomor item produk. Wajib."),
 * @OA\Property(property="unitPrice", type="number", format="double", example=10000.00, description="Harga satuan item. Wajib."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus)."),
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Jenis A"),
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
 * @OA\Property(property="detailName", type="string", nullable=true, example="Material Besi"),
 * @OA\Property(property="detailNotes", type="string", nullable=true, example="Untuk proyek ABC."),
 * @OA\Property(property="itemCashDiscount", type="number", format="double", nullable=true, example=100.00, description="Diskon tunai per item."),
 * @OA\Property(property="itemDiscPercent", type="string", nullable=true, example="10", description="Persentase diskon item."),
 * @OA\Property(property="itemUnitName", type="string", nullable=true, example="KG"),
 * @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-XYZ"),
 * @OA\Property(property="purchaseRequisitionNumber", type="string", nullable=true, example="PR-001", description="Nomor Purchase Requisition terkait."),
 * @OA\Property(property="quantity", type="number", format="double", nullable=true, example=50.0, description="Kuantitas item."),
 * @OA\Property(property="useTax1", type="boolean", nullable=true, example=true, description="Gunakan pajak 1."),
 * @OA\Property(property="useTax2", type="boolean", nullable=true, example=false, description="Gunakan pajak 2."),
 * @OA\Property(property="useTax3", type="boolean", nullable=true, example=false, description="Gunakan pajak 3.")
 * }
 * )
 *
 * --- MAIN SCHEMAS ---
 *
 * @OA\Schema(
 * schema="PurchaseOrderInput",
 * title="Input Pesanan Pembelian",
 * description="Skema untuk data input saat membuat atau memperbarui pesanan pembelian.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=101, description="ID unik pesanan pembelian. Diperlukan untuk update."),
 * @OA\Property(property="vendorNo", type="string", example="SUP-001", description="Nomor vendor (supplier). Wajib."),
 * @OA\Property(property="transDate", type="string", format="date", example="31/03/2016", description="Tanggal transaksi (DD/MM/YYYY). Wajib."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=1, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Pusat", description="Nama cabang."),
 * @OA\Property(property="cashDiscPercent", type="string", nullable=true, example="2", description="Persentase diskon tunai."),
 * @OA\Property(property="cashDiscount", type="number", format="double", nullable=true, example=5000.00, description="Jumlah diskon tunai."),
 * @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR", description="Kode mata uang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Pesanan rutin material."),
 * @OA\Property(property="fillPriceByVendorPrice", type="boolean", nullable=true, example=true, description="Isi harga berdasarkan harga vendor."),
 * @OA\Property(property="fobName", type="string", nullable=true, example="Pabrik Vendor", description="Nama FOB."),
 * @OA\Property(property="inclusiveTax", type="boolean", nullable=true, example=false, description="Apakah pajak termasuk dalam harga."),
 * @OA\Property(property="number", type="string", nullable=true, example="PO-20240625-001", description="Nomor pesanan pembelian."),
 * @OA\Property(property="paymentTermName", type="string", nullable=true, example="Net 30", description="Nama syarat pembayaran."),
 * @OA\Property(property="rate", type="number", format="double", nullable=true, example=1.0, description="Kurs mata uang."),
 * @OA\Property(property="shipDate", type="string", format="date", nullable=true, example="30/06/2024", description="Tanggal pengiriman (DD/MM/YYYY)."),
 * @OA\Property(property="shipmentName", type="string", nullable=true, example="Cargo Cepat", description="Nama pengiriman."),
 * @OA\Property(property="taxable", type="boolean", nullable=true, example=true, description="Apakah dikenakan pajak."),
 * @OA\Property(property="toAddress", type="string", nullable=true, example="Gudang Utama, Jl. Raya No. 1", description="Alamat pengiriman."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="Tipe penomoran otomatis."),
 * @OA\Property(property="detailExpense", type="array", nullable=true, @OA\Items(ref="#/components/schemas/PurchaseOrderDetailExpenseItem"), description="Daftar detail biaya."),
 * @OA\Property(property="detailItem", type="array", nullable=true, @OA\Items(ref="#/components/schemas/PurchaseOrderDetailItem"), description="Daftar detail item.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseOrderData",
 * title="Detail Data Pesanan Pembelian",
 * description="Representasi lengkap data satu pesanan pembelian dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=101, description="ID unik internal pesanan pembelian."),
 * @OA\Property(property="number", type="string", example="PO-20240625-001", description="Nomor pesanan pembelian."),
 * @OA\Property(property="transDate", type="string", example="25/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="vendorName", type="string", example="PT Supplier Maju", description="Nama vendor."),
 * @OA\Property(property="totalAmount", type="number", format="double", example=500000.00, description="Total jumlah pesanan."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Pusat", description="Nama cabang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Pesanan rutin material."),
 * @OA\Property(property="currencyCode", type="string", example="IDR", description="Kode mata uang."),
 * @OA\Property(property="status", type="string", example="OPEN", description="Status pesanan."),
 * @OA\Property(property="detailItem", type="array", @OA\Items(type="object"), description="Daftar item pesanan."),
 * @OA\Property(property="detailExpense", type="array", @OA\Items(type="object"), description="Daftar biaya pesanan."),
 * @OA\Property(property="createDate", type="string", format="date-time", example="2024-06-25 10:00:00"),
 * @OA\Property(property="lastUpdate", type="string", format="date-time", example="2024-06-25 11:00:00"),
 * @OA\Property(property="optLock", type="integer", example=1)
 * },
 * required={"id", "number", "transDate", "totalAmount"}
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="PurchaseOrderListResponse",
 * title="Respons Daftar Pesanan Pembelian",
 * description="Struktur respons untuk daftar pesanan pembelian dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/PurchaseOrderData"), description="Array daftar objek pesanan pembelian."),
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
 * schema="PurchaseOrderSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik Pesanan Pembelian",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus pesanan pembelian yang berhasil.",
 * type="object",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Status sukses dari Accurate API."),
 * @OA\Property(property="m", type="string", example="Data berhasil disimpan.", description="Pesan dari Accurate API."),
 * @OA\Property(property="d", type="integer", example=101, description="ID objek yang baru dibuat/diperbarui/dihapus (opsional).", nullable=true)
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseOrderDetailResponse",
 * title="Respons Detail Pesanan Pembelian",
 * description="Struktur respons untuk detail pesanan pembelian tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/PurchaseOrderData", description="Objek data pesanan pembelian.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseOrderEditResponse",
 * title="Respons Edit Pesanan Pembelian",
 * description="Struktur respons yang menggabungkan detail pesanan pembelian dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/PurchaseOrderData", description="Data pesanan pembelian yang akan diedit."),
 * @OA\Property(property="form_attribute", type="object", description="Atribut form untuk pengeditan (kosong untuk pesanan pembelian).", example={})
 * }
 * )
 */
class OrderSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
