<?php

namespace App\Http\Controllers\Accurate\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\Invoice\DownRequest;
use App\Http\Requests\Purchase\Invoice\FormRequest;
use App\Http\Requests\Purchase\Invoice\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\Purchase\InvoiceSchemas; // Pastikan ini di-use

class InvoiceController extends Controller
{
    protected Accurate $accurate;
    protected $docType;
    protected $trxType;
    protected $taxType;
    protected $docCode; // From your controller, used in downpayForm

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
        $this->docCode = [
            'CTAS_IMPORT',
            'CTAS_INVOICE',
            'CTAS_PURCHASE',
            'CTAS_UNCREDIT',
            'DIGUNGGUNG'
        ];
        $this->docType = [ // Note: This seems to be identical to docCode based on your snippet.
            'CTAS_IMPORT',
            'CTAS_INVOICE',
            'CTAS_PURCHASE',
            'CTAS_UNCREDIT',
            'DIGUNGGUNG'
        ];
        $this->trxType = [
            'CTAS_DOKUMEN_KHUSUS',
            'CTAS_PEMBAYARAN',
            'CTAS_PEMBERITAHUAN_IMPORT',
            'CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN',
            'CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH'
        ];
        $this->taxType = [
            'CTAS_BESARAN_TERTENTU',
            'CTAS_DPP_NILAI_LAIN',
            'CTAS_IMPOR_BARANG_KENA_PAJAK',
            'CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI',
            'CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH',
            'CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH',
            'CTAS_KEPADA_SELAIN_PEMUNGUT_PPN',
            'CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK',
            'CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN',
            'CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN',
            'CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT',
            'CTAS_PENYERAHAN_LAINNYA'
        ];
    }
    /**
     * @OA\Get(
     * path="/purchase/invoice",
     * summary="Mendapatkan Daftar Faktur Pembelian",
     * description="Mengambil daftar semua faktur pembelian dari Accurate dengan dukungan paginasi.",
     * operationId="getPurchaseInvoiceList",
     * tags={"Purchase: Invoice"},
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
     * description="Daftar faktur pembelian berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceListResponse")
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
        $url = 'purchase-invoice/list.do';
        $response = $this->accurate->get(true, $url, [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/purchase/invoice/create",
     * summary="Mendapatkan Atribut Form Pembuatan Faktur Pembelian",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan faktur pembelian baru.",
     * operationId="getPurchaseInvoiceCreateFormAttributes",
     * tags={"Purchase: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceFormAttributesResponse")
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
            'doc_type' => $this->docType,
            'trx_type' => $this->trxType,
            'tax_type' => $this->taxType,
        ]);
    }

    /**
     * @OA\Get(
     * path="/purchase/invoice/downpay/create",
     * summary="Mendapatkan Atribut Form Uang Muka Pembelian",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan uang muka faktur pembelian.",
     * operationId="getPurchaseInvoiceDownPaymentFormAttributes",
     * tags={"Purchase: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Atribut form uang muka berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceDownpayFormAttributesResponse")
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
    public function downpayForm()
    {
        return response()->json([
            'doc_code' => $this->docCode,
            'trx_type' => $this->trxType,
            'tax_type' => $this->taxType,
        ]);
    }

    /**
     * @OA\Post(
     * path="/purchase/invoice",
     * summary="Membuat atau Memperbarui Faktur Pembelian",
     * description="Menambahkan faktur pembelian baru atau memperbarui data faktur pembelian yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdatePurchaseInvoice",
     * tags={"Purchase: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data faktur pembelian untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Faktur pembelian berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Faktur pembelian berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceSaveUpdateDeleteResponse")
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
     * @OA\Property(property="errors", type="object", example={"vendorNo": {"The vendor no field is required."}})
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
        $input = $request->validated();
        $url = 'purchase-invoice/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Post(
     * path="/purchase/invoice/downpay",
     * summary="Membuat Uang Muka Faktur Pembelian",
     * description="Membuat uang muka untuk faktur pembelian.",
     * operationId="createPurchaseInvoiceDownPayment",
     * tags={"Purchase: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data uang muka faktur pembelian.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceDownPaymentInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Uang muka faktur pembelian berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceSaveUpdateDeleteResponse")
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
     * @OA\Property(property="errors", type="object", example={"billNumber": {"The bill number field is required."}})
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function downpay(DownRequest $request)
    {
        $input = $request->validated();
        $url = 'purchase-invoice/create-down-payment.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/purchase/invoice/{id}",
     * summary="Mendapatkan Detail Faktur Pembelian",
     * description="Mengambil detail lengkap satu faktur pembelian berdasarkan ID internalnya.",
     * operationId="getPurchaseInvoiceDetail",
     * tags={"Purchase: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal faktur pembelian.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail faktur pembelian berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceData")
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
     * description="Faktur pembelian tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Invoice not found.")
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
        $url = 'purchase-invoice/detail.do';
        $query = [
            "id" => $id
        ];
        $response = $this->accurate->get(true, $url, [], $query);
        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Purchase Invoice not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/purchase/invoice/{id}/edit",
     * summary="Mendapatkan Detail Faktur Pembelian dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu faktur pembelian berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan.",
     * operationId="getPurchaseInvoiceEditDataAndAttributes",
     * tags={"Purchase: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal faktur pembelian.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail faktur pembelian dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceEditResponse")
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
     * description="Faktur pembelian tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Invoice not found.")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function edit($id)
    {
        try {
            $url = 'purchase-invoice/detail.do';
            $query = [
                "id" => $id
            ];
            $response = $this->accurate->get(true, $url, [], $query);
            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Purchase Invoice not found'], 404);
            }
            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [
                    'doc_type' => $this->docType,
                    'trx_type' => $this->trxType,
                    'tax_type' => $this->taxType,
                ]
            ]);
        } catch (\Throwable $th) {
            \Log::error("Error in Purchase\\InvoiceController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/purchase/invoice",
     * summary="Memperbarui Data Faktur Pembelian (via PUT)",
     * description="Memperbarui data faktur pembelian yang sudah ada. ID faktur pembelian harus disertakan dalam request body.",
     * operationId="updatePurchaseInvoice",
     * tags={"Purchase: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data faktur pembelian untuk diperbarui, termasuk ID faktur pembelian.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Faktur pembelian berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseInvoiceSaveUpdateDeleteResponse")
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
     * description="Faktur pembelian tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Invoice not found or invalid ID.")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Kesalahan validasi input.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="The given data was invalid."),
     * @OA\Property(property="errors", type="object", example={"vendorNo": {"The vendor no field is required."}})
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
        $input = $request->validated();
        $url = 'purchase-invoice/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Delete(
     * path="/purchase/invoice/{id}",
     * summary="Menghapus Faktur Pembelian",
     * description="Menghapus data faktur pembelian berdasarkan ID internalnya.",
     * operationId="deletePurchaseInvoice",
     * tags={"Purchase: Invoice"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal faktur pembelian yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Faktur pembelian berhasil dihapus.",
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
     * description="Faktur pembelian tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Invoice not found or ID not valid for deletion.")
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
        $url = 'purchase-invoice/delete.do';
        $response = $this->accurate->delete(true, $url, [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data faktur pembelian.', 'status' => false], 404);
    }
}
