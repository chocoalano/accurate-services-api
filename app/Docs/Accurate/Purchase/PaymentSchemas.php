<?php

namespace App\Docs\Accurate\Purchase;

/**
 * --- NESTED SCHEMAS FOR PURCHASE PAYMENT INPUT & DATA ---
 *
 * @OA\Schema(
 * schema="PurchasePaymentDetailDiscountItem",
 * title="Item Detail Diskon Pembayaran Pembelian",
 * description="Detail diskon yang diterapkan pada item faktur dalam pembayaran pembelian.",
 * type="object",
 * properties={
 * @OA\Property(property="accountNo", type="string", example="1101-01", description="Nomor akun diskon. Wajib."),
 * @OA\Property(property="amount", type="number", format="double", example=50000.00, description="Jumlah diskon. Wajib."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus)."),
 * @OA\Property(property="departmentName", type="string", nullable=true, example="Pembelian"),
 * @OA\Property(property="discountNotes", type="string", nullable=true, example="Diskon karena pembayaran awal."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-PURCH-001")
 * },
 * required={"accountNo", "amount"}
 * )
 *
 * @OA\Schema(
 * schema="PurchasePaymentDetailInvoiceItem",
 * title="Item Detail Faktur Pembayaran Pembelian",
 * description="Detail faktur yang dibayar dalam pembayaran pembelian.",
 * type="object",
 * properties={
 * @OA\Property(property="invoiceNo", type="string", example="INV-AP-001", description="Nomor faktur yang dibayar. Wajib."),
 * @OA\Property(property="paymentAmount", type="number", format="double", example=1000000.00, description="Jumlah pembayaran untuk faktur ini. Wajib."),
 * @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true, description="Status operasi untuk item detail (misal: 'delete' untuk menghapus)."),
 * @OA\Property(property="id", type="integer", nullable=true, example=1),
 * @OA\Property(property="paidPph", type="boolean", nullable=true, example=true, description="Apakah PPh sudah dibayar."),
 * @OA\Property(property="pphNumber", type="string", nullable=true, example="PPH-001", description="Nomor dokumen PPh."),
 * @OA\Property(property="detailDiscount", type="array", nullable=true, @OA\Items(ref="#/components/schemas/PurchasePaymentDetailDiscountItem"), description="Detail diskon terkait faktur ini.")
 * },
 * required={"invoiceNo", "paymentAmount"}
 * )
 *
 * --- MAIN SCHEMAS ---
 *
 * @OA\Schema(
 * schema="PurchasePaymentInput",
 * title="Input Pembayaran Pembelian",
 * description="Skema lengkap untuk data input saat membuat atau memperbarui pembayaran pembelian.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=101, description="ID unik pembayaran pembelian. Diperlukan untuk operasi update, null/kosong untuk create."),
 * @OA\Property(property="bankNo", type="string", example="BCA-12345", description="Nomor bank yang digunakan untuk pembayaran. Wajib."),
 * @OA\Property(property="chequeAmount", type="number", format="double", example=1500000.00, description="Jumlah pembayaran cek/transfer. Wajib."),
 * @OA\Property(property="transDate", type="string", format="date", example="25/06/2024", description="Tanggal transaksi (DD/MM/YYYY). Wajib."),
 * @OA\Property(property="vendorNo", type="string", example="VEN-001", description="Nomor vendor. Wajib."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=1, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Kantor Pusat", description="Nama cabang."),
 * @OA\Property(property="chequeDate", type="string", format="date", nullable=true, example="25/06/2024", description="Tanggal cek (DD/MM/YYYY)."),
 * @OA\Property(property="chequeNo", type="string", nullable=true, example="CHK-98765", description="Nomor cek."),
 * @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR", description="Kode mata uang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Pembayaran untuk faktur pembelian."),
 * @OA\Property(property="number", type="string", nullable=true, example="PAY-P-2024-001", description="Nomor dokumen pembayaran."),
 * @OA\Property(
 * property="paymentMethod",
 * type="string",
 * nullable=true,
 * enum={"BANK_CHEQUE", "BANK_TRANSFER", "CASH_OTHER", "EDC", "OTHERS", "PAYMENT_LINK", "QRIS", "VIRTUAL_ACCOUNT"},
 * example="BANK_TRANSFER",
 * description="Metode pembayaran."
 * ),
 * @OA\Property(property="rate", type="number", format="double", nullable=true, example=1.0, description="Kurs mata uang."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1, description="Tipe penomoran otomatis."),
 * @OA\Property(property="detailInvoice", type="array", @OA\Items(ref="#/components/schemas/PurchasePaymentDetailInvoiceItem"), description="Detail daftar faktur yang dibayar.")
 * },
 * required={"bankNo", "chequeAmount", "transDate", "vendorNo", "detailInvoice"}
 * )
 *
 * @OA\Schema(
 * schema="PurchasePaymentData",
 * title="Detail Data Pembayaran Pembelian",
 * description="Representasi lengkap data satu pembayaran pembelian dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=101, description="ID unik internal pembayaran."),
 * @OA\Property(property="number", type="string", example="PAY-P-2024-001", description="Nomor dokumen pembayaran."),
 * @OA\Property(property="transDate", type="string", example="25/06/2024", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="vendorName", type="string", example="PT Supplier Maju", description="Nama vendor."),
 * @OA\Property(property="chequeAmount", type="number", format="double", example=1500000.00, description="Jumlah pembayaran cek/transfer."),
 * @OA\Property(property="paymentMethod", type="string", example="BANK_TRANSFER", description="Metode pembayaran."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Kantor Pusat", description="Nama cabang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Pembayaran faktur #INV-001."),
 * @OA\Property(property="currencyCode", type="string", example="IDR", description="Kode mata uang."),
 * @OA\Property(property="status", type="string", example="POSTED", description="Status pembayaran."),
 * @OA\Property(property="detailInvoice", type="array", @OA\Items(type="object"), description="Daftar faktur yang dibayar."),
 * @OA\Property(property="optLock", type="integer", example=1)
 * },
 * required={"id", "number", "transDate", "vendorName", "chequeAmount", "paymentMethod"}
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="PurchasePaymentListResponse",
 * title="Respons Daftar Pembayaran Pembelian",
 * description="Struktur respons untuk daftar pembayaran pembelian dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/PurchasePaymentData"), description="Array daftar objek pembayaran pembelian."),
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
 * schema="PurchasePaymentSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik Pembayaran Pembelian",
 * description="Respons umum dari Accurate API untuk operasi simpan, update, atau hapus pembayaran pembelian yang berhasil.",
 * type="object",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Status sukses dari Accurate API."),
 * @OA\Property(property="m", type="string", example="Data berhasil disimpan.", description="Pesan dari Accurate API."),
 * @OA\Property(property="d", type="integer", example=101, description="ID objek yang baru dibuat/diperbarui/dihapus (opsional).", nullable=true)
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchasePaymentDetailResponse",
 * title="Respons Detail Pembayaran Pembelian",
 * description="Struktur respons untuk detail pembayaran pembelian tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/PurchasePaymentData", description="Objek data pembayaran pembelian.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="PurchasePaymentEditResponse",
 * title="Respons Edit Pembayaran Pembelian",
 * description="Struktur respons yang menggabungkan detail pembayaran pembelian dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/PurchasePaymentData", description="Data pembayaran pembelian yang akan diedit."),
 * @OA\Property(property="form_attribute", type="object", description="Atribut form untuk pengeditan.",
 * properties={
 * @OA\Property(property="payment_method", type="array", @OA\Items(type="string", enum={"BANK_CHEQUE", "BANK_TRANSFER", "CASH_OTHER", "EDC", "OTHERS", "PAYMENT_LINK", "QRIS", "VIRTUAL_ACCOUNT"}), description="Opsi metode pembayaran.")
 * }
 * )
 * }
 * )
 */
class PaymentSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
