<?php

namespace App\Http\Controllers\Accurate\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesInvoice\FormRequest;
use App\Http\Requests\SalesInvoice\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\SalesInvoiceSchemas; // Pastikan ini di-use
use Illuminate\Support\Facades\Log;

class SalesInvoiceController extends Controller
{
    protected Accurate $accurate;

    private array $documentCodeType = [
        'CTAS_DELIVERY',
        'CTAS_EXPORT',
        'CTAS_INVOICE',
        'DIGUNGGUNG',
    ];

    private array $documentTransaction = [
        'CTAS_CUKAI_ROKO',
        'CTAS_DIPERSAMAKAN',
        'CTAS_EKSPOR_BARANG',
        'CTAS_EKSPOR_DOKUMEN',
        'CTAS_PEMBERITAHUAN_EKSPOR_TIDAK_BERWUJUD',
    ];

    private array $taxType = [
        'CTAS_BESARAN_TERTENTU',
        'CTAS_DPP_NILAI_LAIN',
        'CTAS_EKSPOR_BARANG_BERWUJUD',
        'CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD',
        'CTAS_EKSPOR_JASA',
        'CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI',
        'CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH',
        'CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH',
        'CTAS_KEPADA_SELAIN_PEMUNGUT_PPN',
        'CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN',
        'CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN',
        'CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT',
        'CTAS_PENYERAHAN_LAINNYA',
    ];

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/sales-invoice",
     * summary="Mendapatkan Daftar Faktur Penjualan",
     * description="Mengambil daftar semua faktur penjualan dari Accurate dengan dukungan paginasi.",
     * operationId="getSalesInvoiceList",
     * tags={"Sales: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="page",
     * in="query",
     * required=true,
     * description="Nomor halaman.",
     * @OA\Schema(type="integer", minimum=1, example=1)
     * ),
     * @OA\Parameter(
     * name="pageSize",
     * in="query",
     * required=true,
     * description="Jumlah item per halaman.",
     * @OA\Schema(type="integer", minimum=1, example=50)
     * ),
     * @OA\Response(
     * response=200,
     * description="Daftar faktur penjualan berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesInvoiceListResponse")
     * ),
     * @OA\Response(
     * response=401,
     * description="Tidak terautentikasi.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function index(IndexRequest $request)
    {
        $validated = $request->validated();
        $response = $this->accurate->get(true, 'sales-invoice/list.do', [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/sales-invoice/create",
     * summary="Mendapatkan Atribut Form Pembuatan Faktur Penjualan",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan faktur penjualan baru, seperti tipe kode dokumen, tipe transaksi, dan tipe pajak.",
     * operationId="getSalesInvoiceCreateFormAttributes",
     * tags={"Sales: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Atribut form berhasil diambil.",
     * @OA\JsonContent(
     * @OA\Property(property="document_code_type", type="array", @OA\Items(type="string", enum={"CTAS_DELIVERY", "CTAS_EXPORT", "CTAS_INVOICE", "DIGUNGGUNG"}), description="Opsi tipe kode dokumen."),
     * @OA\Property(property="transaction_type", type="array", @OA\Items(type="string", enum={"CTAS_CUKAI_ROKO", "CTAS_DIPERSAMAKAN", "CTAS_EKSPOR_BARANG", "CTAS_EKSPOR_DOKUMEN", "CTAS_PEMBERITAHUAN_EKSPOR_TIDAK_BERWUJUD"}), description="Opsi tipe transaksi."),
     * @OA\Property(property="tax_type", type="array", @OA\Items(type="string", enum={"CTAS_BESARAN_TERTENTU", "CTAS_DPP_NILAI_LAIN", "CTAS_EKSPOR_BARANG_BERWUJUD", "CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD", "CTAS_EKSPOR_JASA", "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI", "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH", "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN", "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN", "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT", "CTAS_PENYERAHAN_LAINNYA"}), description="Opsi tipe pajak.")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Tidak terautentikasi.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function create()
    {
        return response()->json([
            "document_code_type" => $this->documentCodeType,
            "transaction_type" => $this->documentTransaction,
            "tax_type" => $this->taxType,
        ]);
    }
    /**
     * @OA\Post(
     * path="/sales-invoice",
     * summary="Membuat atau Memperbarui Faktur Penjualan",
     * description="Menambahkan faktur penjualan baru atau memperbarui data faktur penjualan yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdateSalesInvoice",
     * tags={"Sales: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data faktur penjualan untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/SalesInvoiceInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Faktur penjualan berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/SalesInvoiceSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Faktur penjualan berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/SalesInvoiceSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=401,
     * description="Tidak terautentikasi.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Kesalahan validasi input.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="The given data was invalid."),
     * @OA\Property(property="errors", type="object", example={"customerNo": {"The customer no field is required."}})
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function store(FormRequest $request)
    {
        return $this->saveInvoice($request->validated());
    }

    /**
     * @OA\Get(
     * path="/sales-invoice/{id}",
     * summary="Mendapatkan Detail Faktur Penjualan",
     * description="Mengambil detail lengkap satu faktur penjualan berdasarkan ID internalnya.",
     * operationId="getSalesInvoiceDetail",
     * tags={"Sales: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal faktur penjualan.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail faktur penjualan berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesInvoiceData")
     * ),
     * @OA\Response(
     * response=401,
     * description="Tidak terautentikasi.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Faktur penjualan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Invoice not found.")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function show(string $id)
    {
        $response = $this->accurate->get(true, 'sales-invoice/detail.do', [], ['id' => $id]);

        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Sales Invoice not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/sales-invoice/{customerNo}/detail-invoice",
     * summary="Mendapatkan Faktur Penjualan Berdasarkan Customer",
     * description="Mengambil daftar faktur penjualan yang terkait dengan nomor pelanggan tertentu.",
     * operationId="getSalesInvoiceByCustomer",
     * tags={"Sales: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="customerNo",
     * in="path",
     * required=true,
     * description="Nomor unik pelanggan.",
     * @OA\Schema(type="string", example="CUST-001")
     * ),
     * @OA\Response(
     * response=200,
     * description="Daftar faktur pelanggan berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesInvoiceDetailInvoiceResponse")
     * ),
     * @OA\Response(
     * response=401,
     * description="Tidak terautentikasi.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Pelanggan atau faktur tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Customer or invoices not found.")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function showInvoice(string $id)
    {
        // Parameter di sini adalah $id, tapi Anda menggunakannya sebagai customerNo
        // Sesuaikan nama parameter atau pastikan penggunaan konsisten.
        // Asumsi $id yang diterima adalah customerNo.
        $response = $this->accurate->get(true, 'sales-invoice/detail-invoice.do', [], ['customerNo' => $id]);

        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Customer or invoices not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/sales-invoice/{id}/edit",
     * summary="Mendapatkan Detail Faktur Penjualan dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu faktur penjualan berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan.",
     * operationId="getSalesInvoiceEditDataAndAttributes",
     * tags={"Sales: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal faktur penjualan.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail faktur penjualan dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesInvoiceEditResponse")
     * ),
     * @OA\Response(
     * response=401,
     * description="Tidak terautentikasi.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Faktur penjualan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Invoice not found.")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function edit(string $id)
    {
        try {
            $response = $this->accurate->get(true, 'sales-invoice/detail.do', [], ['id' => $id]);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Sales Invoice not found'], 404);
            }

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [
                    "document_code_type" => $this->documentCodeType,
                    "transaction_type" => $this->documentTransaction,
                    "tax_type" => $this->taxType,
                ],
            ]);
        } catch (\Throwable $th) {
            Log::error("Error in SalesInvoiceController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/sales-invoice/update",
     * summary="Memperbarui Data Faktur Penjualan (via POST)",
     * description="Memperbarui data faktur penjualan yang sudah ada. ID faktur penjualan harus disertakan dalam request body.",
     * operationId="updateSalesInvoice",
     * tags={"Sales: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data faktur penjualan untuk diperbarui, termasuk ID faktur penjualan.",
     * @OA\JsonContent(ref="#/components/schemas/SalesInvoiceInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Faktur penjualan berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/SalesInvoiceSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=401,
     * description="Tidak terautentikasi.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Faktur penjualan tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Invoice not found or invalid ID.")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Kesalahan validasi input.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="The given data was invalid."),
     * @OA\Property(property="errors", type="object", example={"customerNo": {"The customer no field is required."}})
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function update(FormRequest $request)
    {
        return $this->saveInvoice($request->validated());
    }

    /**
     * @OA\Delete(
     * path="/sales-invoice/{id}",
     * summary="Menghapus Faktur Penjualan",
     * description="Menghapus data faktur penjualan berdasarkan ID internalnya.",
     * operationId="deleteSalesInvoice",
     * tags={"Sales: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal faktur penjualan yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Faktur penjualan berhasil dihapus.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Data berhasil dihapus."),
     * @OA\Property(property="status", type="boolean", example=true)
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Tidak terautentikasi.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Faktur penjualan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Invoice not found or ID not valid for deletion.")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function destroy(string $id)
    {
        $response = $this->accurate->delete(true, 'sales-invoice/delete.do', [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data faktur penjualan.', 'status' => false], 404);
    }

    /**
     * Save or update invoice to Accurate API.
     * @param array $input The validated input data for the sales invoice.
     * @return \Illuminate\Http\JsonResponse
     */
    private function saveInvoice(array $input)
    {
        $response = $this->accurate->post(true, 'sales-invoice/save.do', $input, []);

        return response()->json($response, $response['status']);
    }
}
