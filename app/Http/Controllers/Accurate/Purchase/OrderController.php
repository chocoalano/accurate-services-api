<?php

namespace App\Http\Controllers\Accurate\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\Order\FormRequest;
use App\Http\Requests\Purchase\Order\IndexRequest;
use App\Support\Accurate;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected Accurate $accurate;

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/purchase/order",
     * summary="Mendapatkan Daftar Pesanan Pembelian",
     * description="Mengambil daftar semua pesanan pembelian dari Accurate dengan dukungan paginasi.",
     * operationId="getPurchaseOrderList",
     * tags={"Purchase: Orders"},
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
     * description="Daftar pesanan pembelian berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseOrderListResponse")
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
        $url = 'purchase-order/list.do';
        $response = $this->accurate->get(true, $url, [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/purchase/order/create",
     * summary="Mendapatkan Atribut Form Pembuatan Pesanan Pembelian",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan pesanan pembelian baru. Untuk pesanan pembelian, ini mungkin kosong.",
     * operationId="getPurchaseOrderCreateFormAttributes",
     * tags={"Purchase: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Atribut form berhasil diambil (mungkin kosong).",
     * @OA\JsonContent(type="object", example={})
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
        return response()->json([]);
    }

    /**
     * @OA\Post(
     * path="/purchase/order",
     * summary="Membuat atau Memperbarui Pesanan Pembelian",
     * description="Menambahkan pesanan pembelian baru atau memperbarui data pesanan pembelian yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdatePurchaseOrder",
     * tags={"Purchase: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data pesanan pembelian untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseOrderInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Pesanan pembelian berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseOrderSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Pesanan pembelian berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseOrderSaveUpdateDeleteResponse")
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
        $url = 'purchase-order/save.do'; // Accurate API yang sama untuk create dan update
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, $response['status']);
    }

    /**
     * @OA\Get(
     * path="/purchase/order/{id}",
     * summary="Mendapatkan Detail Pesanan Pembelian",
     * description="Mengambil detail lengkap satu pesanan pembelian berdasarkan ID internalnya.",
     * operationId="getPurchaseOrderDetail",
     * tags={"Purchase: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal pesanan pembelian.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail pesanan pembelian berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseOrderData")
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
     * description="Pesanan pembelian tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Order not found.")
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
        $url = 'purchase-order/detail.do';
        $query = [
            "id" => $id
        ];
        $response = $this->accurate->get(true, $url, [], $query);
        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Purchase Order not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/purchase/order/{id}/edit",
     * summary="Mendapatkan Detail Pesanan Pembelian dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu pesanan pembelian berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan. Untuk pesanan pembelian, atribut form mungkin kosong.",
     * operationId="getPurchaseOrderEditDataAndAttributes",
     * tags={"Purchase: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal pesanan pembelian.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail pesanan pembelian dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseOrderEditResponse")
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
     * description="Pesanan pembelian tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Order not found.")
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
            $url = 'purchase-order/detail.do';
            $query = [
                "id" => $id
            ];
            $response = $this->accurate->get(true, $url, [], $query);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Purchase Order not found'], 404);
            }

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [] // Sesuai dengan create() yang mengembalikan array kosong
            ]);
        } catch (\Throwable $th) {
            Log::error("Error in OrderController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/purchase/order/update",
     * summary="Memperbarui Data Pesanan Pembelian (via POST)",
     * description="Memperbarui data pesanan pembelian yang sudah ada. ID pesanan pembelian harus disertakan dalam request body.",
     * operationId="updatePurchaseOrder",
     * tags={"Purchase: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data pesanan pembelian untuk diperbarui, termasuk ID pesanan pembelian.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseOrderInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Pesanan pembelian berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/PurchaseOrderSaveUpdateDeleteResponse")
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
     * description="Pesanan pembelian tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Order not found or invalid ID.")
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
        $url = 'purchase-order/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, $response['status']);
    }

    /**
     * @OA\Delete(
     * path="/purchase/order/{id}",
     * summary="Menghapus Pesanan Pembelian",
     * description="Menghapus data pesanan pembelian berdasarkan ID internalnya.",
     * operationId="deletePurchaseOrder",
     * tags={"Purchase: Orders"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal pesanan pembelian yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Pesanan pembelian berhasil dihapus.",
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
     * description="Pesanan pembelian tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Order not found or ID not valid for deletion.")
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
        $url = 'purchase-order/delete.do';
        $response = $this->accurate->delete(true, $url, [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data pesanan pembelian.', 'status' => false], 404);
    }
}
