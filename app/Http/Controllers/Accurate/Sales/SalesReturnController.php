<?php

namespace App\Http\Controllers\Accurate\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesReturn\FormRequest;
use App\Http\Requests\SalesReturn\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\SalesReturnSchemas; // Pastikan ini di-use
use Illuminate\Support\Facades\Log;

class SalesReturnController extends Controller
{
    protected Accurate $accurate;
    private array $returnType = [
        'DELIVERY',
        'INVOICE',
        'INVOICE_DP',
        'NO_INVOICE',
    ];
    private array $statusType = [
        'NOT_RETURNED',
        'PARTIALLY_RETURNED',
        'RETURNED',
    ];
    private array $statusTypeItem = [
        'NOT_RETURNED',
        'RETURNED',
    ];

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/sales-return",
     * summary="Mendapatkan Daftar Retur Penjualan",
     * description="Mengambil daftar semua retur penjualan dari Accurate dengan dukungan paginasi.",
     * operationId="getSalesReturnList",
     * tags={"Sales: Return"},
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
     * description="Daftar retur penjualan berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesReturnListResponse")
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
        $response = $this->accurate->get(true, 'sales-return/list.do', [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/sales-return/create",
     * summary="Mendapatkan Atribut Form Pembuatan Retur Penjualan",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan retur penjualan baru, seperti tipe retur dan status.",
     * operationId="getSalesReturnCreateFormAttributes",
     * tags={"Sales: Return"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Atribut form berhasil diambil.",
     * @OA\JsonContent(
     * @OA\Property(property="returnType", type="array", @OA\Items(type="string", enum={"DELIVERY", "INVOICE", "INVOICE_DP", "NO_INVOICE"}), description="Opsi tipe retur."),
     * @OA\Property(property="statusType", type="array", @OA\Items(type="string", enum={"NOT_RETURNED", "PARTIALLY_RETURNED", "RETURNED"}), description="Opsi status retur."),
     * @OA\Property(property="statusTypeItem", type="array", @OA\Items(type="string", enum={"NOT_RETURNED", "RETURNED"}), description="Opsi status item retur.")
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
            "returnType" => $this->returnType,
            "statusType" => $this->statusType,
            "statusTypeItem" => $this->statusTypeItem,
        ]);
    }
    /**
     * @OA\Post(
     * path="/sales-return",
     * summary="Membuat atau Memperbarui Retur Penjualan",
     * description="Menambahkan retur penjualan baru atau memperbarui data retur penjualan yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdateSalesReturn",
     * tags={"Sales: Return"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data retur penjualan untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/SalesReturnInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Retur penjualan berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/SalesReturnSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Retur penjualan berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/SalesReturnSaveUpdateDeleteResponse")
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
        return $this->saveSalesReturn($request->validated()); // Mengubah nama metode
    }

    /**
     * @OA\Get(
     * path="/sales-return/{id}",
     * summary="Mendapatkan Detail Retur Penjualan",
     * description="Mengambil detail lengkap satu retur penjualan berdasarkan ID internalnya.",
     * operationId="getSalesReturnDetail",
     * tags={"Sales: Return"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal retur penjualan.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail retur penjualan berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesReturnData")
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
     * description="Retur penjualan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Return not found.")
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
        $response = $this->accurate->get(true, 'sales-return/detail.do', [], ['id' => $id]);

        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Sales Return not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/sales-return/invoice/{customerNo}",
     * summary="Mendapatkan Retur Penjualan Berdasarkan Customer",
     * description="Mengambil daftar retur penjualan yang terkait dengan nomor pelanggan tertentu.",
     * operationId="getSalesReturnByCustomer",
     * tags={"Sales: Return"},
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
     * description="Daftar retur pelanggan berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesReturnDetailReturnResponse")
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
     * description="Pelanggan atau retur tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Customer or sales returns not found.")
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
        // Asumsi $id yang diterima adalah customerNo.
        $response = $this->accurate->get(true, 'sales-return/detail-return.do', [], ['customerNo' => $id]);

        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Customer or sales returns not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/sales-return/{id}/edit",
     * summary="Mendapatkan Detail Retur Penjualan dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu retur penjualan berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan.",
     * operationId="getSalesReturnEditDataAndAttributes",
     * tags={"Sales: Return"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal retur penjualan.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail retur penjualan dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/SalesReturnEditResponse")
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
     * description="Retur penjualan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Return not found.")
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
            $response = $this->accurate->get(true, 'sales-return/detail.do', [], ['id' => $id]);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Sales Return not found'], 404);
            }

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [
                    "returnType" => $this->returnType,
                    "statusType" => $this->statusType,
                    "statusTypeItem" => $this->statusTypeItem,
                ],
            ]);
        } catch (\Throwable $th) {
            Log::error("Error in SalesReturnController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/sales-return/update",
     * summary="Memperbarui Data Retur Penjualan (via POST)",
     * description="Memperbarui data retur penjualan yang sudah ada. ID retur penjualan harus disertakan dalam request body.",
     * operationId="updateSalesReturn",
     * tags={"Sales: Return"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data retur penjualan untuk diperbarui, termasuk ID retur penjualan.",
     * @OA\JsonContent(ref="#/components/schemas/SalesReturnInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Retur penjualan berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/SalesReturnSaveUpdateDeleteResponse")
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
     * description="Retur penjualan tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Return not found or invalid ID.")
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
        return $this->saveSalesReturn($request->validated());
    }

    /**
     * @OA\Delete(
     * path="/sales-return/{id}",
     * summary="Menghapus Retur Penjualan",
     * description="Menghapus data retur penjualan berdasarkan ID internalnya.",
     * operationId="deleteSalesReturn",
     * tags={"Sales: Return"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal retur penjualan yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Retur penjualan berhasil dihapus.",
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
     * description="Retur penjualan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Sales Return not found or ID not valid for deletion.")
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
        $response = $this->accurate->delete(true, 'sales-return/delete.do', [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data retur penjualan.', 'status' => false], 404);
    }

    /**
     * Save or update sales return to Accurate API.
     * @param array $input The validated input data for the sales return.
     * @return \Illuminate\Http\JsonResponse
     */
    private function saveSalesReturn(array $input) // Mengubah nama metode
    {
        $response = $this->accurate->post(true, 'sales-return/save.do', $input, []);

        return response()->json($response, $response['status']);
    }
}
