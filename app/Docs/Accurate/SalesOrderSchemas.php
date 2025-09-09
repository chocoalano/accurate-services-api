<?php

namespace App\Docs\Accurate;

/**
 * --- NESTED SCHEMAS FOR SALES ORDER INPUT & DATA ---
 *
 * @OA\Schema(
 * schema="SalesOrderDetailCommonFields",
 * title="Fields Umum Detail Sales Order",
 * description="Properti umum untuk detail Expense dan Item dalam Sales Order.",
 * type="object",
 * properties={
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus)."),
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Classification A", description="Klasifikasi data 1."),
 * @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null, description="Klasifikasi data 2."),
 * @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null, description="Klasifikasi data 3."),
 * @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null, description="Klasifikasi data 4."),
 * @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null, description="Klasifikasi data 5."),
 * @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null, description="Klasifikasi data 6."),
 * @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null, description="Klasifikasi data 7."),
 * @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null, description="Klasifikasi data 8."),
 * @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null, description="Klasifikasi data 9."),
 * @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null, description="Klasifikasi data 10."),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Sales Dept", description="Nama departemen."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1, description="ID unik detail."),
 * @OA\Property(property="salesQuotationNumber", type="string", nullable=true, example="SQ-2024-001", description="Nomor Sales Quotation terkait.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesOrderDetailExpenseItem",
 * title="Item Detail Biaya Sales Order",
 * description="Detail biaya dalam Sales Order.",
 * type="object",
 * allOf={
 * @OA\Schema(ref="#/components/schemas/SalesOrderDetailCommonFields")
 * },
 * properties={
 * @OA\Property(property="accountNo", type="string", nullable=true, example="6000-00", description="Nomor akun biaya."),
 * @OA\Property(property="expenseAmount", type="number", format="double", nullable=true, example=50000.00, description="Jumlah biaya."),
 * @OA\Property(property="expenseName", type="string", nullable=true, example="Biaya Pengiriman", description="Nama biaya."),
 * @OA\Property(property="expenseNotes", type="string", nullable=true, example="Catatan pengiriman cepat.", description="Catatan biaya.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesOrderDetailItem",
 * title="Item Detail Produk Sales Order",
 * description="Detail item produk dalam Sales Order.",
 * type="object",
 * allOf={
 * @OA\Schema(ref="#/components/schemas/SalesOrderDetailCommonFields")
 * },
 * properties={
 * @OA\Property(property="itemNo", type="string", example="PROD-001", description="Nomor item produk. Wajib."),
 * @OA\Property(property="unitPrice", type="number", format="double", example=100000.00, description="Harga satuan item. Wajib."),
 * @OA\Property(property="detailName", type="string", nullable=true, example="Nama Detail Item", description="Nama detail item."),
 * @OA\Property(property="detailNotes", type="string", nullable=true, example="Catatan untuk item."),
 * @OA\Property(property="itemCashDiscount", type="number", format="double", nullable=true, example=2000.00, description="Diskon tunai per item."),
 * @OA\Property(property="itemDiscPercent", type="string", nullable=true, example="2", description="Persentase diskon item (misal: '2' atau '5+2')."),
 * @OA\Property(property="itemUnitName", type="string", nullable=true, example="PCS", description="Nama unit item."),
 * @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-SALES-001", description="Nomor proyek."),
 * @OA\Property(property="quantity", type="number", format="double", nullable=true, example=5.0, description="Kuantitas item."),
 * @OA\Property(property="salesmanListNumber", type="array", nullable=true, @OA\Items(type="string"), example={"SALES-001"}, description="Daftar nomor salesman terkait."),
 * @OA\Property(property="useTax1", type="boolean", nullable=true, example=true, description="Gunakan pajak 1."),
 * @OA\Property(property="useTax2", type="boolean", nullable=true, example=false, description="Gunakan pajak 2."),
 * @OA\Property(property="useTax3", type="boolean", nullable=true, example=false, description="Gunakan pajak 3.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="BranchForForm",
 * title="Cabang untuk Form",
 * description="Detail ringkas cabang untuk dropdown di form.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=1, description="ID unik cabang."),
 * @OA\Property(property="name", type="string", example="Kantor Pusat", description="Nama cabang.")
 * }
 * )
 *
 * --- MAIN SCHEMAS ---
 *
 * @OA\Schema(
 * schema="SalesOrderInput",
 * title="Input Sales Order",
 * description="Skema lengkap untuk data input saat membuat atau memperbarui Sales Order.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=101, description="ID unik Sales Order. Diperlukan untuk operasi update, null/kosong untuk create."),
 * @OA\Property(property="customerNo", type="string", example="CUST-001", description="Nomor pelanggan. Wajib."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=1, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="cashDiscPercent", type="string", nullable=true, example="0", description="Persentase diskon tunai."),
 * @OA\Property(property="cashDiscount", type="number", format="double", nullable=true, example=0.0, description="Jumlah diskon tunai."),
 * @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR", description="Kode mata uang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Penjualan produk X ke pelanggan Y."),
 * @OA\Property(property="fobName", type="string", nullable=true, example="Gudang Kami", description="Nama FOB."),
 * @OA\Property(property="inclusiveTax", type="boolean", nullable=true, example=false, description="Apakah pajak termasuk dalam harga."),
 * @OA\Property(property="number", type="string", nullable=true, example="SO-2024-001", description="Nomor Sales Order."),
 * @OA\Property(property="paymentTermName", type="string", nullable=true, example="Net 30", description="Nama syarat pembayaran."),
 * @OA\Property(property="poNumber", type="string", nullable=true, example="PO-CUST-001", description="Nomor PO pelanggan."),
 * @OA\Property(property="rate", type="number", format="double", nullable=true, example=1.0, description="Kurs mata uang."),
 * @OA\Property(property="shipDate", type="string", format="date", nullable=true, example="30/06/2024", description="Tanggal pengiriman (DD/MM/YYYY)."),
 * @OA\Property(property="shipmentName", type="string", nullable=true, example="JNE", description="Nama pengiriman."),
 * @OA\Property(property="taxable", type="boolean", nullable=true, example=true, description="Apakah dikenakan pajak."),
 * @OA\Property(property="toAddress", type="string", nullable=true, example="Jl. Tujuan No. 1", description="Alamat pengiriman."),
 * @OA\Property(property="transDate", type="string", format="date", nullable=true, example="25/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="Tipe penomoran otomatis."),
 * @OA\Property(property="detailExpense", type="array", nullable=true, @OA\Items(ref="#/components/schemas/SalesOrderDetailExpenseItem"), description="Detail daftar biaya."),
 * @OA\Property(property="detailItem", type="array", description="Daftar detail item penjualan.", @OA\Items(ref="#/components/schemas/SalesOrderDetailItem"))
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesOrderData",
 * title="Detail Data Sales Order",
 * description="Representasi lengkap data satu Sales Order dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=101, description="ID unik internal Sales Order."),
 * @OA\Property(property="number", type="string", example="SO-2024-001", description="Nomor Sales Order."),
 * @OA\Property(property="transDate", type="string", example="25/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="customerName", type="string", example="PT Contoh Jaya", description="Nama pelanggan."),
 * @OA\Property(property="totalAmount", type="number", format="double", example=1500000.00, description="Total jumlah Sales Order."),
 * @OA\Property(property="status", type="string", example="OPEN", description="Status Sales Order (OPEN, CLOSED, etc.)."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Pesanan untuk produk elektronik."),
 * @OA\Property(property="currencyCode", type="string", example="IDR", description="Kode mata uang."),
 * @OA\Property(property="detailItem", type="array", @OA\Items(type="object"), description="Daftar item Sales Order."),
 * @OA\Property(property="detailExpense", type="array", @OA\Items(type="object"), description="Daftar biaya Sales Order."),
 * @OA\Property(property="orderClosed", type="boolean", example=false, description="Status apakah order sudah ditutup secara manual.")
 * }
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="SalesOrderListResponse",
 * title="Respons Daftar Sales Order",
 * description="Struktur respons untuk daftar Sales Order dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/SalesOrderData"), description="Array daftar objek Sales Order."),
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
 * schema="SalesOrderFormAttributesResponse",
 * title="Atribut Form Sales Order",
 * description="Daftar opsi dan atribut yang diperlukan untuk form pembuatan/pengeditan Sales Order.",
 * type="object",
 * properties={
 * @OA\Property(property="branch", type="array", @OA\Items(ref="#/components/schemas/BranchForForm"), description="Daftar cabang yang tersedia."),
 * @OA\Property(property="customerTaxTypeOptions", type="array", @OA\Items(type="string", enum={"CTAS_KEPADA_SELAIN_PEMUNGUT_PPN", "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH", "CTAS_EKSPOR_BARANG_BERWUJUD", "CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD", "CTAS_EKSPOR_JASA", "CTAS_DPP_NILAI_LAIN", "CTAS_BESARAN_TERTENTU", "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI", "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT", "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN", "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN"}), description="Opsi tipe pajak pelanggan."),
 * @OA\Property(property="ContactSalutationTypeOptions", type="array", @OA\Items(type="string", enum={"MR", "MRS"}), description="Opsi sapaan kontak.")
 * },
 * required={"branch", "customerTaxTypeOptions", "ContactSalutationTypeOptions"}
 * )
 *
 * @OA\Schema(
 * schema="SalesOrderSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik Sales Order",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus Sales Order yang berhasil.",
 * type="object",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Status sukses dari Accurate API."),
 * @OA\Property(property="m", type="string", example="Data berhasil disimpan.", description="Pesan dari Accurate API."),
 * @OA\Property(property="d", type="integer", example=101, description="ID objek yang baru dibuat/diperbarui/dihapus (opsional).", nullable=true)
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesOrderDetailResponse",
 * title="Respons Detail Sales Order",
 * description="Struktur respons untuk detail Sales Order tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/SalesOrderData", description="Objek data Sales Order.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesOrderEditResponse",
 * title="Respons Edit Sales Order",
 * description="Struktur respons yang menggabungkan detail Sales Order dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/SalesOrderData", description="Data Sales Order yang akan diedit."),
 * @OA\Property(property="form_attribute", ref="#/components/schemas/SalesOrderFormAttributesResponse", description="Atribut form untuk pengeditan.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="SalesOrderCloseResponse",
 * title="Respons Tutup Sales Order Manual",
 * description="Struktur respons untuk operasi tutup/buka Sales Order secara manual.",
 * type="object",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Status sukses dari Accurate API."),
 * @OA\Property(property="m", type="string", example="Order berhasil ditutup/dibuka.", description="Pesan dari Accurate API.")
 * }
 * )
 */
class SalesOrderSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
