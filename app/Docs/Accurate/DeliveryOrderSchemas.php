<?php

namespace App\Docs\Accurate;

/**
 * --- NESTED SCHEMAS FOR DELIVERY ORDER INPUT & DATA ---
 *
 * @OA\Schema(
 * schema="DeliveryOrderDetailItemCommonFields",
 * title="Fields Umum Detail Item Order Pengiriman",
 * description="Properti umum untuk detail item Order Pengiriman.",
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
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Penjualan"),
 * @OA\Property(property="detailName", type="string", nullable=true, example="Detail Item X"),
 * @OA\Property(property="detailNotes", type="string", nullable=true, example="Catatan untuk item ini."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="itemCashDiscount", type="number", format="double", nullable=true, example=0, description="Diskon kas item."),
 * @OA\Property(property="itemDiscPercent", type="string", nullable=true, example="10", description="Persentase diskon item."),
 * @OA\Property(property="itemUnitName", type="string", nullable=true, example="Unit"),
 * @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-Y"),
 * @OA\Property(property="quantity", type="number", format="double", nullable=true, example=5, description="Kuantitas item."),
 * @OA\Property(property="reverseInvoiceNumber", type="string", nullable=true, example=null),
 * @OA\Property(property="salesOrderNumber", type="string", nullable=true, example="SO-001"),
 * @OA\Property(property="salesQuotationNumber", type="string", nullable=true, example="SQ-001"),
 * @OA\Property(property="useTax1", type="boolean", nullable=true, example=true),
 * @OA\Property(property="useTax2", type="boolean", nullable=true, example=false),
 * @OA\Property(property="useTax3", type="boolean", nullable=true, example=false),
 * @OA\Property(property="warehouseName", type="string", nullable=true, example="Gudang Utama"),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus).")
 * }
 * )
 *
 * @OA\Schema(
 * schema="DeliveryOrderDetailSerialNumberItem",
 * title="Item Nomor Seri Order Pengiriman",
 * description="Detail nomor seri untuk item dalam Order Pengiriman.",
 * type="object",
 * properties={
 * @OA\Property(property="expiredDate", type="string", format="date", nullable=true, example="31/12/2025", description="Tanggal kedaluwarsa (DD/MM/YYYY)."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="quantity", type="number", format="double", nullable=true, example=1, description="Kuantitas untuk nomor seri ini."),
 * @OA\Property(property="serialNumberNo", type="string", example="SN-XYZ-123", description="Nomor seri item."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk nomor seri (misal: 'delete' untuk menghapus).")
 * },
 * required={"serialNumberNo"}
 * )
 *
 * @OA\Schema(
 * schema="DeliveryOrderDetailItem",
 * title="Item Detail Order Pengiriman",
 * description="Detail item yang akan dikirim dalam Order Pengiriman.",
 * type="object",
 * allOf={
 * @OA\Schema(ref="#/components/schemas/DeliveryOrderDetailItemCommonFields")
 * },
 * properties={
 * @OA\Property(property="itemNo", type="string", example="ITEM-001", description="Nomor item."),
 * @OA\Property(property="unitPrice", type="number", format="double", example=150000.00, description="Harga satuan item."),
 * @OA\Property(property="controlQuantity", type="number", format="double", nullable=true, example=5, description="Kuantitas kontrol."),
 * @OA\Property(property="salesmanListNumber", type="array", nullable=true, @OA\Items(type="string"), example={"SALES-001"}, description="Daftar nomor salesman terkait."),
 * @OA\Property(property="detailSerialNumber", type="array", nullable=true, @OA\Items(ref="#/components/schemas/DeliveryOrderDetailSerialNumberItem"), description="Daftar nomor seri untuk item ini.")
 * },
 * required={"itemNo", "unitPrice"}
 * )
 *
 * --- MAIN SCHEMAS ---
 *
 * @OA\Schema(
 * schema="DeliveryOrderInput",
 * title="Input Order Pengiriman",
 * description="Skema untuk data input saat membuat atau memperbarui Order Pengiriman.",
 * type="object",
 * properties={
 * @OA\Property(property="customerNo", type="string", example="CUST-001", description="Nomor pelanggan. Wajib."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=1, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Kantor Pusat", description="Nama cabang."),
 * @OA\Property(property="cashDiscPercent", type="string", nullable=true, example="5", description="Persentase diskon tunai."),
 * @OA\Property(property="cashDiscount", type="number", format="double", nullable=true, example=100000.00, description="Jumlah diskon tunai."),
 * @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR", description="Kode mata uang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Pengiriman produk X ke pelanggan Y."),
 * @OA\Property(property="fobName", type="string", nullable=true, example="Origin", description="Free On Board (FOB) nama."),
 * @OA\Property(property="id", type="integer", nullable=true, description="ID unik Order Pengiriman. Diperlukan untuk update."),
 * @OA\Property(property="inclusiveTax", type="boolean", nullable=true, example=true, description="Termasuk pajak."),
 * @OA\Property(property="number", type="string", nullable=true, example="DO-001", description="Nomor dokumen Order Pengiriman."),
 * @OA\Property(property="paymentTermName", type="string", nullable=true, example="Net 30", description="Nama syarat pembayaran."),
 * @OA\Property(property="poNumber", type="string", nullable=true, example="PO-CUST-001", description="Nomor pesanan pembelian."),
 * @OA\Property(property="rate", type="number", format="double", nullable=true, example=1.0, description="Nilai tukar mata uang."),
 * @OA\Property(property="shipmentName", type="string", nullable=true, example="Kurir Cepat", description="Nama metode pengiriman."),
 * @OA\Property(property="taxable", type="boolean", nullable=true, example=true, description="Apakah terkena pajak."),
 * @OA\Property(property="toAddress", type="string", nullable=true, example="Jl. Tujuan No. 5", description="Alamat tujuan pengiriman."),
 * @OA\Property(property="transDate", type="string", format="date", example="25/06/2025", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="Tipe nomor otomatis."),
 * @OA\Property(property="detailItem", type="array", @OA\Items(ref="#/components/schemas/DeliveryOrderDetailItem"), description="Daftar item detail Order Pengiriman.")
 * },
 * required={"customerNo", "detailItem"}
 * )
 *
 * @OA\Schema(
 * schema="DeliveryOrderData",
 * title="Detail Data Order Pengiriman",
 * description="Representasi lengkap data satu Order Pengiriman dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=101, description="ID unik internal Order Pengiriman."),
 * @OA\Property(property="number", type="string", example="DO-2024-001", description="Nomor dokumen Order Pengiriman."),
 * @OA\Property(property="transDate", type="string", example="20/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="customerNo", type="string", example="CUST-001", description="Nomor pelanggan."),
 * @OA\Property(property="customerName", type="string", example="PT. ABC", description="Nama pelanggan."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=50, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Kantor Pusat", description="Nama cabang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Pengiriman batch 1."),
 * @OA\Property(property="inclusiveTax", type="boolean", example=true, description="Termasuk pajak."),
 * @OA\Property(property="taxable", type="boolean", example=true, description="Apakah terkena pajak."),
 * @OA\Property(property="totalAmount", type="number", format="double", example=500000.00, description="Jumlah total order."),
 * @OA\Property(property="detailItem", type="array", @OA\Items(ref="#/components/schemas/DeliveryOrderDetailItem"), description="Daftar item yang dikirim."),
 * @OA\Property(property="createDate", type="string", format="date-time", example="2024-06-20 10:00:00"),
 * @OA\Property(property="lastUpdate", type="string", format="date-time", example="2024-06-20 11:30:00"),
 * @OA\Property(property="optLock", type="integer", example=1)
 * },
 * required={"id", "number", "transDate", "customerNo", "customerName", "detailItem"}
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="DeliveryOrderListResponse",
 * title="Respons Daftar Order Pengiriman",
 * description="Struktur respons untuk daftar Order Pengiriman dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/DeliveryOrderData"), description="Array daftar objek Order Pengiriman."),
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
 * schema="DeliveryOrderSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik Order Pengiriman",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus Order Pengiriman yang berhasil.",
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
 * schema="DeliveryOrderDetailResponse",
 * title="Respons Detail Order Pengiriman",
 * description="Struktur respons untuk detail Order Pengiriman tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/DeliveryOrderData", description="Objek data Order Pengiriman.")
 * },
 * required={"success", "status", "data"}
 * )
 *
 * @OA\Schema(
 * schema="DeliveryOrderEditResponse",
 * title="Respons Edit Order Pengiriman",
 * description="Struktur respons yang menggabungkan detail Order Pengiriman dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/DeliveryOrderData", description="Data Order Pengiriman yang akan diedit."),
 * @OA\Property(property="form_attribute", type="object", description="Atribut form untuk pengeditan (kosong untuk Order Pengiriman).", example={})
 * },
 * required={"data_edit", "form_attribute"}
 * )
 */
class DeliveryOrderSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
