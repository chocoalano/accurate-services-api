<?php

namespace App\Http\Controllers\Accurate\Warehouse;

use App\Http\Controllers\Controller;
use App\Http\Requests\Delivery\FormRequest;
use App\Http\Requests\Delivery\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\DeliveryOrderSchemas; // Pastikan ini di-use
use Illuminate\Support\Facades\Log;

class DeliveryController extends Controller
{
    protected Accurate $accurate;

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/delivery",
     * summary="Mendapatkan Daftar Order Pengiriman",
     * description="Mengambil daftar semua Order Pengiriman dari Accurate dengan dukungan paginasi.",
     * operationId="getDeliveryOrderList",
     * tags={"Gudang: Delivery Order"},
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
     * description="Daftar Order Pengiriman berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/DeliveryOrderListResponse")
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
        $url = 'delivery-order/list.do';
        $response = $this->accurate->get(true, $url, [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/delivery/create",
     * summary="Mendapatkan Atribut Form Pembuatan Order Pengiriman",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan Order Pengiriman baru. Untuk Order Pengiriman, ini mungkin kosong.",
     * operationId="getDeliveryOrderCreateFormAttributes",
     * tags={"Gudang: Delivery Order"},
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
     * path="/delivery",
     * summary="Membuat atau Memperbarui Order Pengiriman",
     * description="Menambahkan Order Pengiriman baru atau memperbarui data Order Pengiriman yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdateDeliveryOrder",
     * tags={"Gudang: Delivery Order"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data Order Pengiriman untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/DeliveryOrderInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Order Pengiriman berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/DeliveryOrderSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Order Pengiriman berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/DeliveryOrderSaveUpdateDeleteResponse")
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
        $url = 'delivery-order/save.do'; // Accurate API yang sama untuk create dan update
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, $response['status']);
    }

    /**
     * @OA\Get(
     * path="/delivery/{id}",
     * summary="Mendapatkan Detail Order Pengiriman",
     * description="Mengambil detail lengkap satu Order Pengiriman berdasarkan ID internalnya.",
     * operationId="getDeliveryOrderDetail",
     * tags={"Gudang: Delivery Order"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Order Pengiriman.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail Order Pengiriman berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/DeliveryOrderData")
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
     * description="Order Pengiriman tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Delivery Order not found.")
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
        $url = 'delivery-order/detail.do';
        $query = [
            "id" => $id
        ];
        $response = $this->accurate->get(true, $url, [], $query);
        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Delivery Order not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/delivery/{id}/edit",
     * summary="Mendapatkan Detail Order Pengiriman dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu Order Pengiriman berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan. Untuk Order Pengiriman, atribut form mungkin kosong.",
     * operationId="getDeliveryOrderEditDataAndAttributes",
     * tags={"Gudang: Delivery Order"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Order Pengiriman.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail Order Pengiriman dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/DeliveryOrderEditResponse")
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
     * description="Order Pengiriman tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Delivery Order not found.")
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
            $url = 'delivery-order/detail.do';
            $query = [
                "id" => $id
            ];
            $response = $this->accurate->get(true, $url, [], $query);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Delivery Order not found'], 404);
            }

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [] // Sesuai dengan create() yang mengembalikan array kosong
            ]);
        } catch (\Throwable $th) {
            Log::error("Error in DeliveryController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/delivery/update",
     * summary="Memperbarui Data Order Pengiriman (via POST)",
     * description="Memperbarui data Order Pengiriman yang sudah ada. ID Order Pengiriman harus disertakan dalam request body.",
     * operationId="updateDeliveryOrder",
     * tags={"Gudang: Delivery Order"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data Order Pengiriman untuk diperbarui, termasuk ID Order Pengiriman.",
     * @OA\JsonContent(ref="#/components/schemas/DeliveryOrderInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Order Pengiriman berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/DeliveryOrderSaveUpdateDeleteResponse")
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
     * description="Order Pengiriman tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Delivery Order not found or invalid ID.")
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
        $url = 'delivery-order/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, $response['status']);
    }

    /**
     * @OA\Delete(
     * path="/delivery/{id}",
     * summary="Menghapus Order Pengiriman",
     * description="Menghapus data Order Pengiriman berdasarkan ID internalnya.",
     * operationId="deleteDeliveryOrder",
     * tags={"Gudang: Delivery Order"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Order Pengiriman yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Order Pengiriman berhasil dihapus.",
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
     * description="Order Pengiriman tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Delivery Order not found or ID not valid for deletion.")
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
        $url = 'delivery-order/delete.do';
        $response = $this->accurate->delete(true, $url, [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data Order Pengiriman.', 'status' => false], 404);
    }
}
