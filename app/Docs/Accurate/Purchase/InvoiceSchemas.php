<?php

namespace App\Docs\Accurate\Purchase;

/**
 * --- NESTED SCHEMAS FOR PURCHASE INVOICE INPUT & DATA ---
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceDetailDownPaymentItem",
 * title="Item Detail Uang Muka Faktur Pembelian",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=1, description="ID unik item uang muka."),
 * @OA\Property(property="invoiceNumber", type="string", nullable=true, example="DP-PI-001", description="Nomor faktur uang muka."),
 * @OA\Property(property="paymentAmount", type="number", format="double", example=250000.00, description="Jumlah pembayaran uang muka."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus).")
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceDetailExpenseItem",
 * title="Item Detail Biaya Faktur Pembelian",
 * type="object",
 * properties={
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus)."),
 * @OA\Property(property="accountNo", type="string", nullable=true, example="5101-01", description="Nomor akun biaya."),
 * @OA\Property(property="allocateToItemCost", type="boolean", nullable=true, example=true, description="Apakah dialokasikan ke biaya item."),
 * @OA\Property(property="amountCurrency", type="number", format="double", nullable=true, example=50000.00, description="Jumlah biaya dalam mata uang."),
 * @OA\Property(property="chargedVendorName", type="string", nullable=true, example="Vendor Layanan A", description="Nama vendor yang dibebankan."),
 * @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Proyek X"),
 * @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null),
 * @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Pembelian"),
 * @OA\Property(property="expenseAmount", type="number", format="double", example=50000.00, description="Jumlah biaya."),
 * @OA\Property(property="expenseCurrencyCode", type="string", nullable=true, example="IDR", description="Kode mata uang biaya."),
 * @OA\Property(property="expenseName", type="string", nullable=true, example="Biaya Pengiriman"),
 * @OA\Property(property="expenseNotes", type="string", nullable=true, example="Biaya pengiriman dari supplier."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="purchaseOrderNumber", type="string", nullable=true, example="PO-001", description="Nomor Purchase Order terkait.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceDetailItem",
 * title="Item Detail Faktur Pembelian",
 * type="object",
 * properties={
 * @OA\Property(property="itemNo", type="string", example="RAW-001", description="Nomor item produk. Wajib."),
 * @OA\Property(property="unitPrice", type="number", format="double", example=100000.00, description="Harga satuan item. Wajib."),
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
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Logistik"),
 * @OA\Property(property="detailName", type="string", nullable=true, example="Detail Material X"),
 * @OA\Property(property="detailNotes", type="string", nullable=true, example="Catatan untuk material ini."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="itemCashDiscount", type="number", format="double", nullable=true, example=0.0, description="Diskon tunai per item."),
 * @OA\Property(property="itemDiscPercent", type="string", nullable=true, example="0", description="Persentase diskon item."),
 * @OA\Property(property="itemUnitName", type="string", nullable=true, example="Unit"),
 * @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-001"),
 * @OA\Property(property="purchaseOrderNumber", type="string", nullable=true, example="PO-001"),
 * @OA\Property(property="purchaseRequisitionNumber", type="string", nullable=true, example="PR-001"),
 * @OA\Property(property="quantity", type="number", format="double", nullable=true, example=5.0, description="Kuantitas item."),
 * @OA\Property(property="receiveItemNumber", type="string", nullable=true, example="RI-001"),
 * @OA\Property(property="useTax1", type="boolean", nullable=true, example=true, description="Gunakan pajak 1."),
 * @OA\Property(property="useTax2", type="boolean", nullable=true, example=false, description="Gunakan pajak 2."),
 * @OA\Property(property="useTax3", type="boolean", nullable=true, example=false, description="Gunakan pajak 3."),
 * @OA\Property(property="warehouseName", type="string", nullable=true, example="Gudang A")
 * }
 * )
 *
 * --- MAIN SCHEMAS ---
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceInput",
 * title="Input Faktur Pembelian",
 * description="Skema lengkap untuk data input saat membuat atau memperbarui faktur pembelian.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=101, description="ID unik faktur pembelian. Diperlukan untuk operasi update, null/kosong untuk create."),
 * @OA\Property(property="vendorNo", type="string", example="VEN-001", description="Nomor vendor. Wajib."),
 * @OA\Property(property="transDate", type="string", format="date", example="31/03/2024", description="Tanggal transaksi (DD/MM/YYYY). Wajib."),
 * @OA\Property(property="billNumber", type="string", nullable=true, example="BILL-123", description="Nomor bill dari vendor."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=1, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="cashDiscPercent", type="string", nullable=true, example="1.5", description="Persentase diskon tunai."),
 * @OA\Property(property="cashDiscount", type="number", format="double", nullable=true, example=5000.00, description="Jumlah diskon tunai."),
 * @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR", description="Kode mata uang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Pembelian material baku."),
 * @OA\Property(
 * property="documentCode",
 * type="string",
 * nullable=true,
 * enum={"CTAS_IMPORT", "CTAS_INVOICE", "CTAS_PURCHASE", "CTAS_UNCREDIT", "DIGUNGGUNG"},
 * example="CTAS_INVOICE",
 * description="Kode dokumen faktur."
 * ),
 * @OA\Property(
 * property="documentTransaction",
 * type="string",
 * nullable=true,
 * enum={"CTAS_DOKUMEN_KHUSUS", "CTAS_PEMBAYARAN", "CTAS_PEMBERITAHUAN_IMPORT", "CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN", "CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH"},
 * example="CTAS_PEMBAYARAN",
 * description="Tipe transaksi dokumen."
 * ),
 * @OA\Property(property="fillPriceByVendorPrice", type="boolean", nullable=true, example=true, description="Isi harga berdasarkan harga vendor."),
 * @OA\Property(property="fiscalRate", type="number", format="double", nullable=true, example=1.0, description="Nilai tukar fiskal."),
 * @OA\Property(property="fobName", type="string", nullable=true, example="Pabrik Vendor", description="Nama FOB."),
 * @OA\Property(property="inclusiveTax", type="boolean", nullable=true, example=false, description="Apakah pajak termasuk dalam harga."),
 * @OA\Property(property="inputDownPayment", type="number", format="double", nullable=true, example=0.0, description="Jumlah uang muka yang dimasukkan."),
 * @OA\Property(property="invoiceDp", type="boolean", nullable=true, example=false, description="Apakah ini faktur uang muka."),
 * @OA\Property(property="number", type="string", nullable=true, example="PI-20240626-001", description="Nomor faktur pembelian."),
 * @OA\Property(property="orderDownPaymentNumber", type="string", nullable=true, example="DP-PO-001", description="Nomor uang muka pesanan."),
 * @OA\Property(property="paymentTermName", type="string", nullable=true, example="Net 30", description="Nama syarat pembayaran."),
 * @OA\Property(property="rate", type="number", format="double", nullable=true, example=1.0, description="Kurs mata uang."),
 * @OA\Property(property="reverseInvoice", type="boolean", nullable=true, example=false, description="Apakah ini faktur balik."),
 * @OA\Property(property="shipDate", type="string", format="date", nullable=true, example="26/06/2024", description="Tanggal pengiriman (DD/MM/YYYY)."),
 * @OA\Property(property="shipmentName", type="string", nullable=true, example="DHL", description="Nama ekspedisi/pengiriman."),
 * @OA\Property(property="tax1Name", type="string", nullable=true, example="PPN"),
 * @OA\Property(property="taxDate", type="string", format="date", nullable=true, example="26/06/2024", description="Tanggal pajak (DD/MM/YYYY)."),
 * @OA\Property(property="taxNumber", type="string", nullable=true, example="FKP-001", description="Nomor faktur pajak."),
 * @OA\Property(property="taxable", type="boolean", nullable=true, example=true, description="Apakah item dikenakan pajak."),
 * @OA\Property(property="toAddress", type="string", nullable=true, example="Jl. Tujuan Gudang", description="Alamat tujuan pengiriman."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="Tipe penomoran otomatis."),
 * @OA\Property(
 * property="vendorTaxType",
 * type="string",
 * nullable=true,
 * enum={
 * "CTAS_BESARAN_TERTENTU", "CTAS_DPP_NILAI_LAIN", "CTAS_IMPOR_BARANG_KENA_PAJAK", "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI", "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN", "CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK", "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT", "CTAS_PENYERAHAN_LAINNYA"
 * },
 * example="CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
 * description="Tipe pajak vendor."
 * ),
 * @OA\Property(property="detailDownPayment", type="array", nullable=true, @OA\Items(ref="#/components/schemas/PurchaseInvoiceDetailDownPaymentItem"), description="Daftar detail uang muka."),
 * @OA\Property(property="detailExpense", type="array", nullable=true, @OA\Items(ref="#/components/schemas/PurchaseInvoiceDetailExpenseItem"), description="Daftar detail biaya."),
 * @OA\Property(property="detailItem", type="array", nullable=true, @OA\Items(ref="#/components/schemas/PurchaseInvoiceDetailItem"), description="Daftar detail item pembelian.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceDownPaymentInput",
 * title="Input Uang Muka Faktur Pembelian",
 * description="Skema untuk data input saat membuat uang muka faktur pembelian.",
 * type="object",
 * properties={
 * @OA\Property(property="billNumber", type="string", example="BILL-DP-001", description="Nomor bill dari vendor. Wajib."),
 * @OA\Property(property="dpAmount", type="number", format="double", example=100000.00, description="Jumlah uang muka. Wajib."),
 * @OA\Property(property="vendorNo", type="string", example="VEN-001", description="Nomor vendor. Wajib."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR", description="Kode mata uang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Uang muka pembelian.", description="Deskripsi uang muka."),
 * @OA\Property(
 * property="documentCode",
 * type="string",
 * nullable=true,
 * enum={"CTAS_IMPORT", "CTAS_INVOICE", "CTAS_PURCHASE", "CTAS_UNCREDIT", "DIGUNGGUNG"},
 * example="CTAS_INVOICE",
 * description="Kode dokumen."
 * ),
 * @OA\Property(
 * property="documentTransaction",
 * type="string",
 * nullable=true,
 * enum={"CTAS_DOKUMEN_KHUSUS", "CTAS_PEMBAYARAN", "CTAS_PEMBERITAHUAN_IMPORT", "CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN", "CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH"},
 * example="CTAS_PEMBAYARAN",
 * description="Tipe transaksi dokumen."
 * ),
 * @OA\Property(property="fiscalRate", type="number", format="double", nullable=true, example=1.0, description="Nilai tukar fiskal."),
 * @OA\Property(property="inclusiveTax", type="boolean", nullable=true, example=false, description="Apakah pajak termasuk dalam harga."),
 * @OA\Property(property="isTaxable", type="boolean", nullable=true, example=true, description="Apakah dikenakan pajak."),
 * @OA\Property(property="number", type="string", nullable=true, example="DP-PI-20240626-001", description="Nomor uang muka."),
 * @OA\Property(property="paymentTermName", type="string", nullable=true, example="Net 30", description="Nama syarat pembayaran."),
 * @OA\Property(property="poNumber", type="string", nullable=true, example="PO-001", description="Nomor PO terkait."),
 * @OA\Property(property="rate", type="number", format="double", nullable=true, example=1.0, description="Kurs mata uang."),
 * @OA\Property(property="tax1Name", type="string", nullable=true, example="PPN"),
 * @OA\Property(property="taxDate", type="string", format="date", nullable=true, example="26/06/2024", description="Tanggal pajak (DD/MM/YYYY)."),
 * @OA\Property(property="taxNumber", type="string", nullable=true, example="FAK-PAJAK-DP-001", description="Nomor faktur pajak."),
 * @OA\Property(property="toAddress", type="string", nullable=true, example="Jl. Penerima DP", description="Alamat penerima."),
 * @OA\Property(property="transDate", type="string", format="date", nullable=true, example="26/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="Tipe penomoran otomatis."),
 * @OA\Property(
 * property="vendorTaxType",
 * type="string",
 * nullable=true,
 * enum={
 * "CTAS_BESARAN_TERTENTU", "CTAS_DPP_NILAI_LAIN", "CTAS_IMPOR_BARANG_KENA_PAJAK", "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI", "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN", "CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK", "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT", "CTAS_PENYERAHAN_LAINNYA"
 * },
 * example="CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
 * description="Tipe pajak vendor."
 * )
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceData",
 * title="Detail Data Faktur Pembelian",
 * description="Representasi lengkap data satu faktur pembelian dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=101, description="ID unik internal faktur."),
 * @OA\Property(property="number", type="string", example="PI-20240626-001", description="Nomor faktur pembelian."),
 * @OA\Property(property="transDate", type="string", example="26/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="vendorName", type="string", example="PT Supplier Maju", description="Nama vendor."),
 * @OA\Property(property="totalAmount", type="number", format="double", example=1500000.00, description="Total jumlah faktur."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama", description="Nama cabang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Pembelian bahan baku.", description="Deskripsi faktur."),
 * @OA\Property(property="currencyCode", type="string", example="IDR", description="Kode mata uang."),
 * @OA\Property(property="status", type="string", example="OPEN", description="Status faktur (OPEN, PAID, etc.)."),
 * @OA\Property(property="detailItem", type="array", @OA\Items(type="object"), description="Daftar item faktur."),
 * @OA\Property(property="detailExpense", type="array", @OA\Items(type="object"), description="Daftar biaya faktur."),
 * @OA\Property(property="detailDownPayment", type="array", @OA\Items(type="object"), description="Daftar uang muka faktur.")
 * },
 * required={"id", "number", "transDate", "vendorName", "totalAmount"}
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceListResponse",
 * title="Respons Daftar Faktur Pembelian",
 * description="Struktur respons untuk daftar faktur pembelian dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/PurchaseInvoiceData"), description="Array daftar objek faktur pembelian."),
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
 * schema="PurchaseInvoiceSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik Faktur Pembelian",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus faktur pembelian yang berhasil.",
 * type="object",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Status sukses dari Accurate API."),
 * @OA\Property(property="m", type="string", example="Data berhasil disimpan.", description="Pesan dari Accurate API."),
 * @OA\Property(property="d", type="integer", example=101, description="ID objek yang baru dibuat/diperbarui/dihapus (opsional).", nullable=true)
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceDetailResponse",
 * title="Respons Detail Faktur Pembelian",
 * description="Struktur respons untuk detail faktur pembelian tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/PurchaseInvoiceData", description="Objek data faktur pembelian.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceFormAttributesResponse",
 * title="Atribut Form Faktur Pembelian",
 * description="Daftar opsi dan atribut yang diperlukan untuk form pembuatan/pengeditan faktur pembelian.",
 * type="object",
 * properties={
 * @OA\Property(property="doc_type", type="array", @OA\Items(type="string", enum={"CTAS_IMPORT", "CTAS_INVOICE", "CTAS_PURCHASE", "CTAS_UNCREDIT", "DIGUNGGUNG"}), description="Opsi tipe dokumen."),
 * @OA\Property(property="trx_type", type="array", @OA\Items(type="string", enum={"CTAS_DOKUMEN_KHUSUS", "CTAS_PEMBAYARAN", "CTAS_PEMBERITAHUAN_IMPORT", "CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN", "CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH"}), description="Opsi tipe transaksi."),
 * @OA\Property(property="tax_type", type="array", @OA\Items(type="string", enum={"CTAS_BESARAN_TERTENTU", "CTAS_DPP_NILAI_LAIN", "CTAS_IMPOR_BARANG_KENA_PAJAK", "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI", "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN", "CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK", "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT", "CTAS_PENYERAHAN_LAINNYA"}), description="Opsi tipe pajak.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceDownpayFormAttributesResponse",
 * title="Atribut Form Uang Muka Faktur Pembelian",
 * description="Daftar opsi dan atribut yang diperlukan untuk form pembuatan uang muka faktur pembelian.",
 * type="object",
 * properties={
 * @OA\Property(property="doc_code", type="array", @OA\Items(type="string", enum={"CTAS_IMPORT", "CTAS_INVOICE", "CTAS_PURCHASE", "CTAS_UNCREDIT", "DIGUNGGUNG"}), description="Opsi kode dokumen."),
 * @OA\Property(property="trx_type", type="array", @OA\Items(type="string", enum={"CTAS_DOKUMEN_KHUSUS", "CTAS_PEMBAYARAN", "CTAS_PEMBERITAHUAN_IMPORT", "CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN", "CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH"}), description="Opsi tipe transaksi."),
 * @OA\Property(property="tax_type", type="array", @OA\Items(type="string", enum={"CTAS_BESARAN_TERTENTU", "CTAS_DPP_NILAI_LAIN", "CTAS_IMPOR_BARANG_KENA_PAJAK", "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI", "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN", "CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK", "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT", "CTAS_PENYERAHAN_LAINNYA"}), description="Opsi tipe pajak.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchaseInvoiceEditResponse",
 * title="Respons Edit Faktur Pembelian",
 * description="Struktur respons yang menggabungkan detail faktur pembelian dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/PurchaseInvoiceData", description="Data faktur pembelian yang akan diedit."),
 * @OA\Property(property="form_attribute", ref="#/components/schemas/PurchaseInvoiceFormAttributesResponse", description="Atribut form untuk pengeditan.")
 * }
 * )
 */
class InvoiceSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
