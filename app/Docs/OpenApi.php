<?php

namespace App\Docs;

/**
 * @OA\Info(
 * version="1.0.0",
 * title="Accurate Agen AC Service - API Karyawan",
 * description="Dokumentasi API ini dibuat sebagai penjembatan antar aplikasi dengan basis HTTP REQUEST agar dapat terintegrasi dengan Accurate Online.",
 * @OA\Contact(
 * email="alan@sinergiabadisentosa.com"
 * ),
 * @OA\License(
 * name="PT. SINERGI ABADI SENTOSA",
 * url="https://sinergiabadisentosa.com"
 * )
 * )
 *
 * @OA\Server(
 * url="http://localhost:8000/api",
 * description="Server Lokal Pengembangan"
 * )
 *
 * @OA\Tag(
 * name="Autentikasi",
 * description="Operasi terkait login dan otentikasi pengguna. Otentikasi ini diperlukan untuk dapat melakukan akses pada tiap endpoint."
 * )
 * @OA\Tag(
 * name="Karyawan",
 * description="Mengelola data karyawan: melihat, menambah, memperbarui, menghapus, dan mencari karyawan. Tag ini mengelompokkan semua endpoint terkait informasi karyawan."
 * )
 * @OA\Tag(
 * name="Sales: Invoice",
 * description="Mengelola data kebutuhan sales: melihat, menambah, memperbarui, menghapus, dan mencari invoice. Tag ini mengelompokkan semua endpoint terkait informasi data invoice penjualan sales."
 * )
 * )
 * @OA\Tag(
 * name="Sales: Orders",
 * description="Mengelola data kebutuhan sales: melihat, menambah, memperbarui, menghapus, dan mencari pesanan (orders). Tag ini mengelompokkan semua endpoint terkait informasi data pesanan (orders) penjualan sales."
 * )
 * )
 * @OA\Tag(
 * name="Sales: Return",
 * description="Mengelola data kebutuhan sales: melihat, menambah, memperbarui, menghapus, dan mencari penarikan/pengembalian (return). Tag ini mengelompokkan semua endpoint terkait informasi data penarikan/pengembalian (return) pesanan penjualan sales."
 * )
 * )
 * @OA\Tag(
 * name="Produksi: Bill Of Material",
 * description="Mengelola data Bill Of Material (BOM): melihat, menambah, memperbarui, menghapus, dan mencari daftar komponen serta instruksi yang diperlukan untuk memproduksi suatu barang. Tag ini mengelompokkan semua endpoint terkait definisi dan manajemen struktur produk."
 * )
 * @OA\Tag(
 * name="Cabang (Branch)",
 * description="Mengelola data cabang perusahaan: melihat daftar cabang, menambah cabang baru, memperbarui informasi cabang yang sudah ada, serta menghapus atau mengaktifkan/menonaktifkan status cabang. Tag ini mengelompokkan semua endpoint yang berkaitan dengan manajemen lokasi atau unit bisnis perusahaan."
 * )
 * @OA\Tag(
 * name="Pelanggan (Customer)",
 * description="Mengelola data pelanggan: melihat daftar pelanggan, menambah detail pelanggan baru, memperbarui informasi pelanggan yang sudah ada (seperti alamat, kontak, atau status), serta mencari dan mengelola relasi dengan pelanggan. Tag ini mengelompokkan semua endpoint terkait manajemen data master pelanggan."
 * )
 * @OA\Tag(
 * name="Purchase: Invoice",
 * description="Mengelola data faktur pembelian (supplier invoice): melihat daftar, menambah faktur baru, memperbarui detail faktur yang sudah ada, serta menghapus atau mencari faktur pembelian. Tag ini mengelompokkan semua endpoint terkait manajemen dan informasi faktur dari pemasok."
 * )
 * @OA\Tag(
 * name="Purchase: Orders",
 * description="Mengelola data pesanan pembelian (purchase orders): melihat daftar pesanan, membuat pesanan pembelian baru, memperbarui pesanan yang sedang berjalan, serta menghapus atau mencari pesanan pembelian. Tag ini mengelompokkan semua endpoint terkait proses dan informasi pemesanan barang/jasa kepada pemasok."
 * )
 * @OA\Tag(
 * name="Purchase: Payment",
 * description="Mengelola data pembayaran pembelian: melihat detail pembayaran, menambah catatan pembayaran baru ke pemasok, memperbarui detail pembayaran, serta menghapus atau mencari transaksi pembayaran pembelian. Tag ini mengelompokkan semua endpoint terkait proses pembayaran kepada pemasok dan pengembalian dana (jika ada)."
 * )
 * @OA\Tag(
 * name="Gudang: Delivery Order",
 * description="Mengelola data Delivery Order (Surat Jalan/Pengiriman Barang): melihat daftar Delivery Order, membuat Delivery Order baru, memperbarui status atau detail pengiriman yang sudah ada, serta menghapus atau mencari Delivery Order. Tag ini mengelompokkan semua endpoint yang berkaitan dengan proses pengeluaran barang dari gudang untuk dikirim ke pelanggan."
 * )
 * @OA\Tag(
 * name="Gudang: Finish Good",
 * description="Mengelola data barang jadi (Finish Good) di gudang: melihat inventaris barang jadi, mencatat penerimaan atau pengeluaran barang jadi, melakukan penyesuaian stok, serta mencari informasi barang jadi. Tag ini mengelompokkan semua endpoint terkait manajemen persediaan dan informasi barang jadi di dalam gudang."
 * )
 * @OA\Tag(
 * name="Gudang: Warehouse",
 * description="Mengelola data master gudang dan operasional umum gudang: melihat daftar lokasi gudang, menambah atau memperbarui informasi gudang, mengelola perpindahan barang antar gudang, serta mencari data terkait gudang secara keseluruhan. Tag ini mengelompokkan semua endpoint yang berkaitan dengan struktur fisik dan operasional manajemen gudang."
 * )
 *
 * @OA\Components(
 * @OA\SecurityScheme(
 * securityScheme="BearerAuth",
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * description="Masukkan **token JWT** di sini (tanpa prefix `Bearer `). Contoh: `eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...`"
 * ),
 * @OA\Schema(
 * schema="LoginInput",
 * type="object",
 * required={"email", "password"},
 * @OA\Property(property="email", type="string", format="email", example="user@example.com", description="Email pengguna."),
 * @OA\Property(property="password", type="string", format="password", example="secret_password", description="Password pengguna.")
 * ),
 * @OA\Schema(
 * schema="LoginResponse",
 * type="object",
 * properties={
 * @OA\Property(property="message", type="string", example="Login successful"),
 * @OA\Property(property="access_token", type="string", description="Token akses JWT yang digunakan untuk otentikasi API.", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
 * @OA\Property(property="token_type", type="string", example="Bearer"),
 * @OA\Property(property="expires_in", type="integer", description="Waktu kedaluwarsa token dalam detik.", example="3600")
 * },
 * required={"message", "access_token", "token_type", "expires_in"}
 * )
 * )
 */
class OpenApi
{
    // Anda tidak perlu menulis kode PHP di sini, hanya anotasi
}
