<?php

namespace App\Http\Controllers\Accurate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branch\FormRequest;
use App\Http\Requests\Branch\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\BranchSchemas; // Pastikan ini di-use

class BranchController extends Controller
{
    protected Accurate $accurate;

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/branch",
     * summary="Mendapatkan Daftar Cabang",
     * description="Mengambil daftar semua cabang dari Accurate dengan dukungan paginasi.",
     * operationId="getBranchList",
     * tags={"Cabang (Branch)"},
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
     * description="Daftar cabang berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/BranchListResponse")
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
        $url = 'branch/list.do';
        $response = $this->accurate->get(true, $url, [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/branch/create",
     * summary="Mendapatkan Atribut Form Pembuatan Cabang",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan cabang baru. Untuk cabang, ini mungkin kosong.",
     * operationId="getBranchCreateFormAttributes",
     * tags={"Cabang (Branch)"},
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
     * path="/branch",
     * summary="Membuat atau Memperbarui Cabang",
     * description="Menambahkan cabang baru atau memperbarui data cabang yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdateBranch",
     * tags={"Cabang (Branch)"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data cabang untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/BranchInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Cabang berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/BranchSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Cabang berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/BranchSaveUpdateDeleteResponse")
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
        $url = 'branch/save.do'; // Accurate API yang sama untuk create dan update
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/branch/{id}",
     * summary="Mendapatkan Detail Cabang",
     * description="Mengambil detail lengkap satu cabang berdasarkan ID internalnya.",
     * operationId="getBranchDetail",
     * tags={"Cabang (Branch)"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal cabang.",
     * @OA\Schema(type="string", example="50")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail cabang berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/BranchData")
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
     * description="Cabang tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Branch not found.")
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
        $url = 'branch/detail.do';
        $query = [
            "id" => $id
        ];
        $response = $this->accurate->get(true, $url, [], $query);
        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Branch not found'], 404); // Handle not found
    }

    /**
     * @OA\Get(
     * path="/branch/{id}/edit",
     * summary="Mendapatkan Detail Cabang dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu cabang berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan. Untuk cabang, atribut form mungkin kosong.",
     * operationId="getBranchEditDataAndAttributes",
     * tags={"Cabang (Branch)"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal cabang.",
     * @OA\Schema(type="string", example="50")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail cabang dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/BranchEditResponse")
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
     * description="Cabang tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Branch not found.")
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
            $url = 'branch/detail.do';
            $query = [
                "id" => $id
            ];
            $response = $this->accurate->get(true, $url, [], $query);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Branch not found'], 404);
            }

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [] // Sesuai dengan create() yang mengembalikan array kosong
            ]);
        } catch (\Throwable $th) {
            \Log::error("Error in BranchController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/branch/update",
     * summary="Memperbarui Data Cabang (via POST)",
     * description="Memperbarui data cabang yang sudah ada. ID cabang harus disertakan dalam request body.",
     * operationId="updateBranch",
     * tags={"Cabang (Branch)"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data cabang untuk diperbarui, termasuk ID cabang.",
     * @OA\JsonContent(ref="#/components/schemas/BranchInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Cabang berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/BranchSaveUpdateDeleteResponse")
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
     * description="Cabang tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Branch not found or invalid ID.")
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
        $url = 'branch/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Delete(
     * path="/branch/{id}",
     * summary="Menghapus Cabang",
     * description="Menghapus data cabang berdasarkan ID internalnya.",
     * operationId="deleteBranch",
     * tags={"Cabang (Branch)"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal cabang yang akan dihapus.",
     * @OA\Schema(type="string", example="50")
     * ),
     * @OA\Response(
     * response=200,
     * description="Cabang berhasil dihapus.",
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
     * description="Cabang tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Branch not found or ID not valid for deletion.")
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
        $url = 'branch/delete.do';
        $response = $this->accurate->delete(true, $url, [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data cabang.', 'status' => false], 404);
    }
}
