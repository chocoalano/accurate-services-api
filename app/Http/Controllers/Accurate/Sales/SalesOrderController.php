<?php

namespace App\Http\Controllers\Accurate\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesOrder\FormRequest;
use App\Http\Requests\SalesOrder\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\SalesOrderSchemas; // Pastikan ini di-use

class SalesOrderController extends Controller
{
    protected Accurate $accurate;

    // Default options for form attributes, if not fetched dynamically
    private array $csTaxTypeOptions = [
        'CTAS_KEPADA_SELAIN_PEMUNGUT_PPN',
        'CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH',
        'CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH',
        'CTAS_EKSPOR_BARANG_BERWUJUD',
        'CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD',
        'CTAS_EKSPOR_JASA',
        'CTAS_DPP_NILAI_LAIN',
        'CTAS_BESARAN_TERTENTU',
        'CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI',
        'CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT',
        'CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN',
        'CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN',
    ];

    private array $ContactSalutationTypeOptions = [
        'MR',
        'MRS',
    ];

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/sales-order",
     * summary="Mendapatkan Daftar Sales Order",
     * description="Mengambil daftar semua Sales Order dari Accurate dengan dukungan paginasi.",
     * operationId="getSalesOrderList",
     * tags={"Sales: Orders"},
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
     * description="Daftar Sales Order berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesOrderListResponse")
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
        $url = 'sales-order/list.do';
        $response = $this->accurate->get(true, $url, [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/sales-order/create",
     * summary="Mendapatkan Atribut Form Pembuatan Sales Order",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan Sales Order baru, seperti daftar cabang dan opsi pajak/sapaan pelanggan.",
     * operationId="getSalesOrderCreateFormAttributes",
     * tags={"Sales: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesOrderFormAttributesResponse")
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
        $branch = $this->accurate->get(true, 'branch/list.do', [], []);
        return response()->json([
            'branch' => $branch['data']['d'] ?? [], // Fallback jika 'd' tidak ada
            'customerTaxTypeOptions' => $this->csTaxTypeOptions,
            'ContactSalutationTypeOptions' => $this->ContactSalutationTypeOptions
        ]);
    }

    /**
     * @OA\Post(
     * path="/sales-order",
     * summary="Membuat atau Memperbarui Sales Order",
     * description="Menambahkan Sales Order baru atau memperbarui data Sales Order yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdateSalesOrder",
     * tags={"Sales: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data Sales Order untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/SalesOrderInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Sales Order berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/SalesOrderSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Sales Order berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/SalesOrderSaveUpdateDeleteResponse")
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
        $input = $request->validated();
        $url = 'sales-order/save.do'; // Accurate API yang sama untuk create dan update
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/sales-order/{id}",
     * summary="Mendapatkan Detail Sales Order",
     * description="Mengambil detail lengkap satu Sales Order berdasarkan ID internalnya.",
     * operationId="getSalesOrderDetail",
     * tags={"Sales: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Sales Order.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail Sales Order berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesOrderData")
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
     * description="Sales Order tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Order not found.")
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
        $url = 'sales-order/detail.do';
        $query = [
            "id" => $id
        ];
        $response = $this->accurate->get(true, $url, [], $query);
        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Sales Order not found'], 404);
    }

    /**
     * @OA\Put(
     * path="/sales-order/{id}/close/{isClose}",
     * summary="Menutup atau Membuka Sales Order Secara Manual",
     * description="Mengubah status Sales Order menjadi ditutup (closed) atau dibuka kembali (open) secara manual berdasarkan nomor Sales Order.",
     * operationId="manualCloseOpenSalesOrder",
     * tags={"Sales: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="Nomor unik Sales Order (bukan ID internal).",
     * @OA\Schema(type="string", example="SO-2024-001")
     * ),
     * @OA\Parameter(
     * name="isClose",
     * in="path",
     * required=true,
     * description="Status yang diinginkan: 'true' untuk tutup, 'false' untuk buka.",
     * @OA\Schema(type="boolean", example=true)
     * ),
     * @OA\Response(
     * response=200,
     * description="Operasi tutup/buka Sales Order berhasil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesOrderCloseResponse")
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
     * description="Sales Order tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Order not found.")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function close(string $id, bool $isclose)
    {
        $url = 'sales-order/manual-close-order.do';
        $query = [
            "number" => $id,
            "orderClosed" => $isclose
        ];
        $response = $this->accurate->get(true, $url, [], $query); // Asumsi ini adalah GET, jika POST/PUT sesuaikan
        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/sales-order/{id}/edit",
     * summary="Mendapatkan Detail Sales Order dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu Sales Order berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan.",
     * operationId="getSalesOrderEditDataAndAttributes",
     * tags={"Sales: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Sales Order.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail Sales Order dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesOrderEditResponse")
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
     * description="Sales Order tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Order not found.")
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
            $url = 'sales-order/detail.do';
            $query = [
                "id" => $id
            ];
            $response = $this->accurate->get(true, $url, [], $query);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Sales Order not found'], 404);
            }

            // Fetch dynamic attributes for the form (e.g., branches)
            $branch = $this->accurate->get(true, 'branch/list.do', [], []);

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [
                    'branch' => $branch['data']['d'] ?? [], // Fallback jika 'd' tidak ada
                    'customerTaxTypeOptions' => $this->csTaxTypeOptions,
                    'ContactSalutationTypeOptions' => $this->ContactSalutationTypeOptions
                ]
            ]);
        } catch (\Throwable $th) {
            \Log::error("Error in SalesOrderController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/sales-order/update",
     * summary="Memperbarui Data Sales Order (via POST)",
     * description="Memperbarui data Sales Order yang sudah ada. ID Sales Order harus disertakan dalam request body.",
     * operationId="updateSalesOrder",
     * tags={"Sales: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data Sales Order untuk diperbarui, termasuk ID Sales Order.",
     * @OA\JsonContent(ref="#/components/schemas/SalesOrderInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Sales Order berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/SalesOrderSaveUpdateDeleteResponse")
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
     * description="Sales Order tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Order not found or invalid ID.")
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
        $input = $request->validated();
        $url = 'sales-order/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Delete(
     * path="/sales-order/{id}",
     * summary="Menghapus Sales Order",
     * description="Menghapus data Sales Order berdasarkan ID internalnya.",
     * operationId="deleteSalesOrder",
     * tags={"Sales: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Sales Order yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Sales Order berhasil dihapus.",
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
     * description="Sales Order tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Order not found or ID not valid for deletion.")
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
        $url = 'sales-order/delete.do';
        $response = $this->accurate->delete(true, $url, [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data Sales Order.', 'status' => false], 404);
    }
}
