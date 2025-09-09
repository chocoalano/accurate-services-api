<?php

namespace App\Http\Controllers\Accurate\Warehouse;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warehouse\FormRequest;
use App\Http\Requests\Warehouse\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\WarehouseSchemas; // Pastikan ini di-use

class WarehouseController extends Controller
{
    protected Accurate $accurate;

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/warehouse",
     * summary="Mendapatkan Daftar Gudang",
     * description="Mengambil daftar semua gudang dari Accurate dengan dukungan paginasi.",
     * operationId="getWarehouseList",
     * tags={"Gudang: Warehouse"},
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
     * description="Daftar gudang berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/WarehouseListResponse")
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
        $url = 'warehouse/list.do';
        $response = $this->accurate->get(true, $url, [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/warehouse/create",
     * summary="Mendapatkan Atribut Form Pembuatan Gudang",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan gudang baru. Untuk gudang, ini mungkin kosong.",
     * operationId="getWarehouseCreateFormAttributes",
     * tags={"Gudang: Warehouse"},
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
     * path="/warehouse",
     * summary="Membuat atau Memperbarui Gudang",
     * description="Menambahkan gudang baru atau memperbarui data gudang yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdateWarehouse",
     * tags={"Gudang: Warehouse"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data gudang untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/WarehouseInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Gudang berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/WarehouseSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Gudang berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/WarehouseSaveUpdateDeleteResponse")
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
     * @OA\Property(property="errors", type="object", example={"name": {"The name field is required."}})
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
        $url = 'warehouse/save.do'; // Accurate API yang sama untuk create dan update
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/warehouse/{id}",
     * summary="Mendapatkan Detail Gudang",
     * description="Mengambil detail lengkap satu gudang berdasarkan ID internalnya.",
     * operationId="getWarehouseDetail",
     * tags={"Gudang: Warehouse"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal gudang.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail gudang berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/WarehouseData")
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
     * description="Gudang tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Warehouse not found.")
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
        $url = 'warehouse/detail.do';
        $query = [
            "id" => $id
        ];
        $response = $this->accurate->get(true, $url, [], $query);
        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Warehouse not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/warehouse/{id}/edit",
     * summary="Mendapatkan Detail Gudang dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu gudang berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan. Untuk gudang, atribut form mungkin kosong.",
     * operationId="getWarehouseEditDataAndAttributes",
     * tags={"Gudang: Warehouse"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal gudang.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail gudang dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/WarehouseEditResponse")
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
     * description="Gudang tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Warehouse not found.")
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
            $url = 'warehouse/detail.do';
            $query = [
                "id" => $id
            ];
            $response = $this->accurate->get(true, $url, [], $query);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Warehouse not found'], 404);
            }

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [] // Sesuai dengan create() yang mengembalikan array kosong
            ]);
        } catch (\Throwable $th) {
            \Log::error("Error in WarehouseController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/warehouse/update",
     * summary="Memperbarui Data Gudang (via POST)",
     * description="Memperbarui data gudang yang sudah ada. ID gudang harus disertakan dalam request body.",
     * operationId="updateWarehouse",
     * tags={"Gudang: Warehouse"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data gudang untuk diperbarui, termasuk ID gudang.",
     * @OA\JsonContent(ref="#/components/schemas/WarehouseInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Gudang berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/WarehouseSaveUpdateDeleteResponse")
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
     * description="Gudang tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Warehouse not found or invalid ID.")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Kesalahan validasi input.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="The given data was invalid."),
     * @OA\Property(property="errors", type="object", example={"name": {"The name field is required."}})
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
        $url = 'warehouse/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Delete(
     * path="/warehouse/{id}",
     * summary="Menghapus Gudang",
     * description="Menghapus data gudang berdasarkan ID internalnya.",
     * operationId="deleteWarehouse",
     * tags={"Gudang: Warehouse"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal gudang yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Gudang berhasil dihapus.",
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
     * description="Gudang tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Warehouse not found or ID not valid for deletion.")
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
        $url = 'warehouse/delete.do';
        $response = $this->accurate->delete(true, $url, [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data gudang.', 'status' => false], 404);
    }
}
