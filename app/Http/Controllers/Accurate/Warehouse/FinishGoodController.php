<?php

namespace App\Http\Controllers\Accurate\Warehouse;

use App\Http\Controllers\Controller;
use App\Http\Requests\FinishGood\FormRequest;
use App\Http\Requests\FinishGood\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\Warehouse\FinishGoodSchemas; // Pastikan ini di-use

class FinishGoodController extends Controller
{
    protected Accurate $accurate;

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/finish-good",
     * summary="Mendapatkan Daftar Finish Good Slip",
     * description="Mengambil daftar semua Finish Good Slip dari Accurate dengan dukungan paginasi.",
     * operationId="getFinishGoodSlipList",
     * tags={"Gudang: Finish Good"},
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
     * description="Daftar Finish Good Slip berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/FinishGoodSlipListResponse")
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
        $url = 'finished-good-slip/list.do';
        $response = $this->accurate->get(true, $url, [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/finish-good/create",
     * summary="Mendapatkan Atribut Form Pembuatan Finish Good Slip",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan Finish Good Slip baru. Untuk FGS, ini mungkin kosong.",
     * operationId="getFinishGoodSlipCreateFormAttributes",
     * tags={"Gudang: Finish Good"},
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
     * path="/finish-good",
     * summary="Membuat atau Memperbarui Finish Good Slip",
     * description="Menambahkan Finish Good Slip baru atau memperbarui data Finish Good Slip yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdateFinishGoodSlip",
     * tags={"Gudang: Finish Good"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data Finish Good Slip untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/FinishGoodSlipInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Finish Good Slip berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/FinishGoodSlipSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Finish Good Slip berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/FinishGoodSlipSaveUpdateDeleteResponse")
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
     * @OA\Property(property="errors", type="object", example={"branchId": {"The branch id field is required."}})
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
        $url = 'finished-good-slip/save.do'; // Accurate API yang sama untuk create dan update
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/finish-good/{id}",
     * summary="Mendapatkan Detail Finish Good Slip",
     * description="Mengambil detail lengkap satu Finish Good Slip berdasarkan ID internalnya.",
     * operationId="getFinishGoodSlipDetail",
     * tags={"Gudang: Finish Good"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Finish Good Slip.",
     * @OA\Schema(type="string", example="201")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail Finish Good Slip berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/FinishGoodSlipData")
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
     * description="Finish Good Slip tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Finish Good Slip not found.")
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
        $url = 'finished-good-slip/detail.do';
        $query = [
            "id" => $id
        ];
        $response = $this->accurate->get(true, $url, [], $query);
        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Finish Good Slip not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/finish-good/{id}/edit",
     * summary="Mendapatkan Detail Finish Good Slip dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu Finish Good Slip berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan. Untuk FGS, atribut form mungkin kosong.",
     * operationId="getFinishGoodSlipEditDataAndAttributes",
     * tags={"Gudang: Finish Good"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Finish Good Slip.",
     * @OA\Schema(type="string", example="201")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail Finish Good Slip dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/FinishGoodSlipEditResponse")
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
     * description="Finish Good Slip tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Finish Good Slip not found.")
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
            $url = 'finished-good-slip/detail.do';
            $query = [
                "id" => $id
            ];
            $response = $this->accurate->get(true, $url, [], $query);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Finish Good Slip not found'], 404);
            }

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [] // Sesuai dengan create() yang mengembalikan array kosong
            ]);
        } catch (\Throwable $th) {
            \Log::error("Error in FinishGoodController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/finish-good/update",
     * summary="Memperbarui Data Finish Good Slip (via POST)",
     * description="Memperbarui data Finish Good Slip yang sudah ada. ID Finish Good Slip harus disertakan dalam request body.",
     * operationId="updateFinishGoodSlip",
     * tags={"Gudang: Finish Good"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data Finish Good Slip untuk diperbarui, termasuk ID Finish Good Slip.",
     * @OA\JsonContent(ref="#/components/schemas/FinishGoodSlipInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Finish Good Slip berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/FinishGoodSlipSaveUpdateDeleteResponse")
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
     * description="Finish Good Slip tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Finish Good Slip not found or invalid ID.")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Kesalahan validasi input.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="The given data was invalid."),
     * @OA\Property(property="errors", type="object", example={"branchId": {"The branch id field is required."}})
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
        $url = 'finished-good-slip/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Delete(
     * path="/finish-good/{id}",
     * summary="Menghapus Finish Good Slip",
     * description="Menghapus data Finish Good Slip berdasarkan ID internalnya.",
     * operationId="deleteFinishGoodSlip",
     * tags={"Gudang: Finish Good"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Finish Good Slip yang akan dihapus.",
     * @OA\Schema(type="string", example="201")
     * ),
     * @OA\Response(
     * response=200,
     * description="Finish Good Slip berhasil dihapus.",
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
     * description="Finish Good Slip tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Finish Good Slip not found or ID not valid for deletion.")
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
        $url = 'finished-good-slip/delete.do';
        $response = $this->accurate->delete(true, $url, [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data Finish Good Slip.', 'status' => false], 404);
    }
}
