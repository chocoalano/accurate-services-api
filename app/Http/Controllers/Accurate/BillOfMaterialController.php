<?php

namespace App\Http\Controllers\Accurate;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillOfMaterial\FormRequest;
use App\Http\Requests\BillOfMaterial\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\BillOfMaterialSchemas; // Pastikan ini di-use
use Illuminate\Support\Facades\Log;

class BillOfMaterialController extends Controller
{
    protected Accurate $accurate;

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/bill-of-material",
     * summary="Mendapatkan Daftar Bill of Material",
     * description="Mengambil daftar semua Bill of Material dari Accurate dengan dukungan paginasi.",
     * operationId="getBillOfMaterialList",
     * tags={"Produksi: Bill Of Material"},
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
     * description="Daftar Bill of Material berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/BillOfMaterialListResponse")
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
        $url = 'bill-of-material/list.do';
        $response = $this->accurate->get(true, $url, [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/bill-of-material/create",
     * summary="Mendapatkan Atribut Form Pembuatan Bill of Material",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan Bill of Material baru. Untuk BOM, ini mungkin kosong.",
     * operationId="getBillOfMaterialCreateFormAttributes",
     * tags={"Produksi: Bill Of Material"},
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
     * path="/bill-of-material",
     * summary="Membuat atau Memperbarui Bill of Material",
     * description="Menambahkan Bill of Material baru atau memperbarui data Bill of Material yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdateBillOfMaterial",
     * tags={"Produksi: Bill Of Material"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data Bill of Material untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/BillOfMaterialInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Bill of Material berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/BillOfMaterialSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Bill of Material berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/BillOfMaterialSaveUpdateDeleteResponse")
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
     * @OA\Property(property="errors", type="object", example={"itemNo": {"The item no field is required."}})
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
        $url = 'bill-of-material/save.do'; // Accurate API yang sama untuk create dan update
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, $response['status']);
    }

    /**
     * @OA\Get(
     * path="/bill-of-material/{id}",
     * summary="Mendapatkan Detail Bill of Material",
     * description="Mengambil detail lengkap satu Bill of Material berdasarkan ID internalnya.",
     * operationId="getBillOfMaterialDetail",
     * tags={"Produksi: Bill Of Material"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Bill of Material.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail Bill of Material berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/BillOfMaterialData")
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
     * description="Bill of Material tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Bill of Material not found.")
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
        $url = 'bill-of-material/detail.do';
        $query = [
            "id" => $id
        ];
        $response = $this->accurate->get(true, $url, [], $query);
        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Bill of Material not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/bill-of-material/{id}/edit",
     * summary="Mendapatkan Detail Bill of Material dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu Bill of Material berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan. Untuk BOM, atribut form mungkin kosong.",
     * operationId="getBillOfMaterialEditDataAndAttributes",
     * tags={"Produksi: Bill Of Material"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Bill of Material.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail Bill of Material dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/BillOfMaterialEditResponse")
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
     * description="Bill of Material tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Bill of Material not found.")
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
            $url = 'bill-of-material/detail.do';
            $query = [
                "id" => $id
            ];
            $response = $this->accurate->get(true, $url, [], $query);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Bill of Material not found'], 404);
            }

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [] // Sesuai dengan create() yang mengembalikan array kosong
            ]);
        } catch (\Throwable $th) {
            Log::error("Error in BillOfMaterialController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/bill-of-material/update",
     * summary="Memperbarui Data Bill of Material (via POST)",
     * description="Memperbarui data Bill of Material yang sudah ada. ID Bill of Material harus disertakan dalam request body.",
     * operationId="updateBillOfMaterial",
     * tags={"Produksi: Bill Of Material"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data Bill of Material untuk diperbarui, termasuk ID Bill of Material.",
     * @OA\JsonContent(ref="#/components/schemas/BillOfMaterialInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Bill of Material berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/BillOfMaterialSaveUpdateDeleteResponse")
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
     * description="Bill of Material tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Bill of Material not found or invalid ID.")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Kesalahan validasi input.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="The given data was invalid."),
     * @OA\Property(property="errors", type="object", example={"itemNo": {"The item no field is required."}})
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
        $url = 'bill-of-material/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, $response['status']);
    }

    /**
     * @OA\Delete(
     * path="/bill-of-material/{id}",
     * summary="Menghapus Bill of Material",
     * description="Menghapus data Bill of Material berdasarkan ID internalnya.",
     * operationId="deleteBillOfMaterial",
     * tags={"Produksi: Bill Of Material"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal Bill of Material yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Bill of Material berhasil dihapus.",
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
     * description="Bill of Material tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Bill of Material not found or ID not valid for deletion.")
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
        $url = 'bill-of-material/delete.do';
        $response = $this->accurate->delete(true, $url, [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data Bill of Material.', 'status' => false], 404);
    }
}
