<?php

namespace App\Docs\Accurate;

/**
 * --- NESTED SCHEMAS FOR SALES INVOICE INPUT & DATA ---
 *
 * @OA\Schema(
 * schema="SalesInvoiceDetailDownPaymentItem",
 * title="Item Detail Uang Muka Penjualan",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=1, description="ID unik item uang muka."),
 * @OA\Property(property="invoiceNumber", type="string", nullable=true, example="DP-INV-001", description="Nomor faktur uang muka."),
 * @OA\Property(property="paymentAmount", type="number", format="double", example=500000.00, description="Jumlah pembayaran uang muka."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus).")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesInvoiceDetailExpenseItem",
 * title="Item Detail Biaya Penjualan",
 * type="object",
 * properties={
 * @OA\Property(property="accountNo", type="string", nullable=true, example="1101-01", description="Nomor akun biaya."),
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Wilayah Timur"),
 * @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Marketing"),
 * @OA\Property(property="expenseAmount", type="number", format="double", example=100000.00, description="Jumlah biaya."),
 * @OA\Property(property="expenseName", type="string", nullable=true, example="Biaya Transportasi"),
 * @OA\Property(property="expenseNotes", type="string", nullable=true, example="Perjalanan dinas ke Bandung."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="salesOrderNumber", type="string", nullable=true, example="SO-001", description="Nomor Sales Order terkait."),
 * @OA\Property(property="salesQuotationNumber", type="string", nullable=true, example="SQ-001", description="Nomor Sales Quotation terkait."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus).")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesInvoiceDetailSerialNumberItem",
 * title="Item Detail Nomor Seri",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=1, description="ID unik nomor seri."),
 * @OA\Property(property="expiredDate", type="string", format="date", nullable=true, example="31/12/2025", description="Tanggal kedaluwarsa (DD/MM/YYYY)."),
 * @OA\Property(property="quantity", type="number", format="double", nullable=true, example=1.0, description="Kuantitas untuk nomor seri ini."),
 * @OA\Property(property="serialNumberNo", type="string", nullable=true, example="SN12345ABC", description="Nomor seri."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus).")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesInvoiceDetailItem",
 * title="Item Detail Faktur Penjualan",
 * type="object",
 * properties={
 * @OA\Property(property="itemNo", type="string", example="ITEM001", description="Nomor item produk. Wajib."),
 * @OA\Property(property="unitPrice", type="number", format="double", example=150000.00, description="Harga satuan item. Wajib."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus)."),
 * @OA\Property(property="controlQuantity", type="number", format="double", nullable=true, example=10.0, description="Kuantitas kontrol (jika berbeda dari kuantitas)."),
 * @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Region A"),
 * @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null),
 * @OA\Property(property="deliveryOrderNumber", type="string", nullable=true, example="DO-001"),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Warehouse"),
 * @OA\Property(property="detailName", type="string", nullable=true, example="Detail Produk X"),
 * @OA\Property(property="detailNotes", type="string", nullable=true, example="Catatan untuk item ini."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="itemCashDiscount", type="number", format="double", nullable=true, example=5000.00, description="Diskon tunai per item."),
 * @OA\Property(property="itemDiscPercent", type="string", nullable=true, example="5", description="Persentase diskon item (misal: '5' untuk 5%, '5+2' untuk diskon bertingkat)."),
 * @OA\Property(property="itemUnitName", type="string", nullable=true, example="PCS"),
 * @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-002"),
 * @OA\Property(property="quantity", type="number", format="double", nullable=true, example=10.0, description="Kuantitas item."),
 * @OA\Property(property="salesOrderNumber", type="string", nullable=true, example="SO-001"),
 * @OA\Property(property="salesQuotationNumber", type="string", nullable=true, example="SQ-001"),
 * @OA\Property(property="salesmanListNumber", type="array", nullable=true, @OA\Items(type="string"), example={"SM-001", "SM-002"}, description="Daftar nomor salesman terkait."),
 * @OA\Property(property="useTax1", type="boolean", nullable=true, example=true, description="Gunakan pajak 1."),
 * @OA\Property(property="useTax2", type="boolean", nullable=true, example=false, description="Gunakan pajak 2."),
 * @OA\Property(property="useTax3", type="boolean", nullable=true, example=false, description="Gunakan pajak 3."),
 * @OA\Property(property="warehouseName", type="string", nullable=true, example="Gudang A"),
 * @OA\Property(property="detailSerialNumber", type="array", nullable=true, @OA\Items(ref="#/components/schemas/SalesInvoiceDetailSerialNumberItem"), description="Detail daftar nomor seri.")
 * }
 * )
 *
 * --- MAIN SCHEMAS ---
 *
 * @OA\Schema(
 * schema="SalesInvoiceInput",
 * title="Input Faktur Penjualan",
 * description="Skema lengkap untuk data input saat membuat atau memperbarui faktur penjualan.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=101, description="ID unik faktur penjualan. Diperlukan untuk operasi update, null/kosong untuk create."),
 * @OA\Property(property="customerNo", type="string", example="CUST-001", description="Nomor pelanggan. Wajib."),
 * @OA\Property(property="transDate", type="string", format="date", example="31/03/2016", description="Tanggal transaksi (DD/MM/YYYY). Wajib."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=1, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="cashDiscPercent", type="string", nullable=true, example="2", description="Persentase diskon tunai."),
 * @OA\Property(property="cashDiscount", type="number", format="double", nullable=true, example=10000.00, description="Jumlah diskon tunai."),
 * @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR", description="Kode mata uang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Faktur penjualan reguler."),
 * @OA\Property(
 * property="documentCode",
 * type="string",
 * nullable=true,
 * enum={"CTAS_DELIVERY", "CTAS_EXPORT", "CTAS_INVOICE", "DIGUNGGUNG"},
 * example="CTAS_INVOICE",
 * description="Kode dokumen faktur."
 * ),
 * @OA\Property(
 * property="documentTransaction",
 * type="string",
 * nullable=true,
 * enum={"CTAS_CUKAI_ROKO", "CTAS_DIPERSAMAKAN", "CTAS_EKSPOR_BARANG", "CTAS_EKSPOR_DOKUMEN", "CTAS_PEMBERITAHUAN_EKSPOR_TIDAK_BERWUJUD"},
 * example="CTAS_EKSPOR_BARANG",
 * description="Tipe transaksi dokumen."
 * ),
 * @OA\Property(property="fiscalRate", type="number", format="double", nullable=true, example=1.0, description="Nilai tukar fiskal."),
 * @OA\Property(property="fobName", type="string", nullable=true, example="Gudang Penjual", description="Nama FOB."),
 * @OA\Property(property="inclusiveTax", type="boolean", nullable=true, example=true, description="Apakah pajak termasuk dalam harga."),
 * @OA\Property(property="inputDownPayment", type="number", format="double", nullable=true, example=0.0, description="Jumlah uang muka yang dimasukkan."),
 * @OA\Property(property="invoiceDp", type="boolean", nullable=true, example=false, description="Apakah ini faktur uang muka."),
 * @OA\Property(property="number", type="string", nullable=true, example="INV-20240625-001", description="Nomor faktur penjualan."),
 * @OA\Property(property="orderDownPaymentNumber", type="string", nullable=true, example="DP-SO-001", description="Nomor uang muka pesanan."),
 * @OA\Property(property="paymentTermName", type="string", nullable=true, example="Net 30", description="Nama syarat pembayaran."),
 * @OA\Property(property="poNumber", type="string", nullable=true, example="PO-CUST-001", description="Nomor PO pelanggan."),
 * @OA\Property(property="rate", type="number", format="double", nullable=true, example=1.0, description="Kurs mata uang."),
 * @OA\Property(property="retailIdCard", type="string", nullable=true, example="3174xxxxxxxxxx", description="Nomor KTP pelanggan retail."),
 * @OA\Property(property="retailWpName", type="string", nullable=true, example="Budi Retail", description="Nama WP pelanggan retail."),
 * @OA\Property(property="reverseInvoice", type="boolean", nullable=true, example=false, description="Apakah ini faktur balik."),
 * @OA\Property(property="shipDate", type="string", format="date", nullable=true, example="25/06/2024", description="Tanggal pengiriman (DD/MM/YYYY)."),
 * @OA\Property(property="shipmentName", type="string", nullable=true, example="JNE", description="Nama ekspedisi/pengiriman."),
 * @OA\Property(property="tax1Name", type="string", nullable=true, example="PPN", description="Nama pajak 1."),
 * @OA\Property(property="taxDate", type="string", format="date", nullable=true, example="25/06/2024", description="Tanggal pajak (DD/MM/YYYY)."),
 * @OA\Property(property="taxNumber", type="string", nullable=true, example="FAK-PAJAK-001", description="Nomor faktur pajak."),
 * @OA\Property(
 * property="taxType",
 * type="string",
 * nullable=true,
 * enum={
 * "CTAS_BESARAN_TERTENTU", "CTAS_DPP_NILAI_LAIN", "CTAS_EKSPOR_BARANG_BERWUJUD", "CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD", "CTAS_EKSPOR_JASA", "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI", "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN", "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT", "CTAS_PENYERAHAN_LAINNYA"
 * },
 * example="CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
 * description="Tipe pajak faktur."
 * ),
 * @OA\Property(property="taxable", type="boolean", nullable=true, example=true, description="Apakah barang dikenakan pajak."),
 * @OA\Property(property="toAddress", type="string", nullable=true, example="Jl. Tujuan No. 5", description="Alamat pengiriman."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="Tipe penomoran otomatis."),
 * @OA\Property(property="detailDownPayment", type="array", nullable=true, @OA\Items(ref="#/components/schemas/SalesInvoiceDetailDownPaymentItem"), description="Daftar detail uang muka."),
 * @OA\Property(property="detailExpense", type="array", nullable=true, @OA\Items(ref="#/components/schemas/SalesInvoiceDetailExpenseItem"), description="Daftar detail biaya."),
 * @OA\Property(property="detailItem", type="array", nullable=true, @OA\Items(ref="#/components/schemas/SalesInvoiceDetailItem"), description="Daftar detail item penjualan.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesInvoiceData",
 * title="Detail Data Faktur Penjualan",
 * description="Representasi lengkap data satu faktur penjualan dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=101, description="ID unik internal faktur."),
 * @OA\Property(property="number", type="string", example="INV-20240625-001", description="Nomor faktur penjualan."),
 * @OA\Property(property="transDate", type="string", example="25/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="customerName", type="string", example="PT Contoh Jaya", description="Nama pelanggan."),
 * @OA\Property(property="totalAmount", type="number", format="double", example=1500000.00, description="Total jumlah faktur."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Penjualan produk elektronik."),
 * @OA\Property(property="currencyCode", type="string", example="IDR", description="Kode mata uang."),
 * @OA\Property(property="status", type="string", example="OPEN", description="Status faktur (OPEN, PAID, etc.)."),
 * @OA\Property(property="detailItem", type="array", @OA\Items(type="object"), description="Daftar item faktur."),
 * @OA\Property(property="detailExpense", type="array", @OA\Items(type="object"), description="Daftar biaya faktur."),
 * @OA\Property(property="detailDownPayment", type="array", @OA\Items(type="object"), description="Daftar uang muka faktur.")
 * }
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="SalesInvoiceListResponse",
 * title="Respons Daftar Faktur Penjualan",
 * description="Struktur respons untuk daftar faktur penjualan dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/SalesInvoiceData"), description="Array daftar objek faktur penjualan."),
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
 * schema="SalesInvoiceSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik Faktur Penjualan",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus faktur penjualan yang berhasil.",
 * type="object",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Status sukses dari Accurate API."),
 * @OA\Property(property="m", type="string", example="Data berhasil disimpan.", description="Pesan dari Accurate API."),
 * @OA\Property(property="d", type="integer", example=101, description="ID objek yang baru dibuat/diperbarui/dihapus (opsional).", nullable=true)
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesInvoiceDetailResponse",
 * title="Respons Detail Faktur Penjualan",
 * description="Struktur respons untuk detail faktur penjualan tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/SalesInvoiceData", description="Objek data faktur penjualan.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesInvoiceEditResponse",
 * title="Respons Edit Faktur Penjualan",
 * description="Struktur respons yang menggabungkan detail faktur penjualan dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/SalesInvoiceData", description="Data faktur penjualan yang akan diedit."),
 * @OA\Property(property="form_attribute", type="object", description="Atribut form untuk pengeditan.",
 * properties={
 * @OA\Property(property="document_code_type", type="array", @OA\Items(type="string", enum={"CTAS_DELIVERY", "CTAS_EXPORT", "CTAS_INVOICE", "DIGUNGGUNG"}), description="Opsi tipe kode dokumen."),
 * @OA\Property(property="transaction_type", type="array", @OA\Items(type="string", enum={"CTAS_CUKAI_ROKO", "CTAS_DIPERSAMAKAN", "CTAS_EKSPOR_BARANG", "CTAS_EKSPOR_DOKUMEN", "CTAS_PEMBERITAHUAN_EKSPOR_TIDAK_BERWUJUD"}), description="Opsi tipe transaksi."),
 * @OA\Property(property="tax_type", type="array", @OA\Items(type="string", enum={"CTAS_BESARAN_TERTENTU", "CTAS_DPP_NILAI_LAIN", "CTAS_EKSPOR_BARANG_BERWUJUD", "CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD", "CTAS_EKSPOR_JASA", "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI", "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN", "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT", "CTAS_PENYERAHAN_LAINNYA"}), description="Opsi tipe pajak.")
 * }
 * )
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesInvoiceDetailInvoiceResponse",
 * title="Respons Detail Faktur Pelanggan",
 * description="Struktur respons untuk daftar faktur pelanggan berdasarkan nomor pelanggan.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/SalesInvoiceData"), description="Daftar faktur yang terkait dengan pelanggan.")
 * }
 * )
 */
class SalesInvoiceSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
