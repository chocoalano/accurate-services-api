<?php

namespace App\Http\Controllers\Accurate\Item;

use App\Http\Controllers\Controller;
use App\Support\Accurate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Docs\Accurate\Product\ItemCataegorySchemas;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\FacadesLog;

/**
 * @OA\Tag(
 *   name="Product: Item Categories",
 *   description="Endpoint integrasi Kategori Item (Item Category) Accurate Online"
 * )
 */
class CategoryController extends Controller
{
    public function __construct(protected Accurate $accurate)
    {
    }

    /**
     * @OA\Get(
     *   path="/product/item-categories",
     *   summary="Daftar Kategori Item",
     *   description="Ambil daftar kategori item dari Accurate dengan paginasi, pencarian (sp.keyword), dan pemilihan fields.",
     *   operationId="accurateItemCategoryIndex",
     *   tags={"Product: Item Categories"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(
     *     name="page", in="query", required=false,
     *     description="Nomor halaman (default 1)",
     *     @OA\Schema(type="integer", minimum=1, example=1)
     *   ),
     *   @OA\Parameter(
     *     name="pageSize", in="query", required=false,
     *     description="Jumlah per halaman (default 50, max 200)",
     *     @OA\Schema(type="integer", minimum=1, example=50)
     *   ),
     *   @OA\Parameter(
     *     name="keyword", in="query", required=false,
     *     description="Kata kunci pencarian (di-map ke sp.keyword)",
     *     @OA\Schema(type="string", example="BEVERAGE")
     *   ),
     *   @OA\Parameter(
     *     name="fields", in="query", required=false,
     *     description="Daftar field dipisah koma (mis. id,name,code,parent)",
     *     @OA\Schema(type="string", example="id,name,code,parent")
     *   ),
     *   @OA\Response(
     *     response=200, description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="data", type="array",
     *         @OA\Items(type="object", example={"id":101,"name":"BEVERAGE","code":"CAT-BEV","parent":null})
     *       ),
     *       @OA\Property(property="meta", type="object",
     *         @OA\Property(property="page", type="integer", example=1),
     *         @OA\Property(property="pageSize", type="integer", example=50),
     *         @OA\Property(property="total", type="integer", nullable=true, example=137)
     *       )
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $page = (int) $request->query('page', 1);
            $pageSize = (int) $request->query('pageSize', 50);
            $pageSize = min(max($pageSize, 1), 200);

            $query = [
                'sp.page'     => $page,
                'sp.pageSize' => $pageSize,
            ];

            if ($kw = $request->query('keyword')) {
                $query['sp.keyword'] = $kw;
            }
            if ($fields = $request->query('fields')) {
                $query['fields'] = $fields;
            }

            $res = $this->accurate->get(true, 'item-category/list.do', [], $query);

            return response()->json([
                'success' => true,
                'data' => $res['data']['d'] ?? [],
                'meta' => [
                    'page' => $page,
                    'pageSize' => $pageSize,
                    'total' => $res['data']['sp']['rowCount'] ?? null,
                ],
            ], 200);
        } catch (\Throwable $e) {
            Log::error('ItemCategory@index error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/product/item-categories/{id}",
     *   summary="Detail Kategori Item",
     *   description="Ambil detail kategori item berdasarkan ID internal Accurate.",
     *   operationId="accurateItemCategoryShow",
     *   tags={"Product: Item Categories"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(
     *     name="id", in="path", required=true,
     *     description="ID internal kategori di Accurate",
     *     @OA\Schema(type="integer", example=101)
     *   ),
     *   @OA\Response(
     *     response=200, description="OK",
     *     @OA\JsonContent(type="object", example={"id":101,"name":"BEVERAGE","code":"CAT-BEV","parent":null})
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function show(string $id): JsonResponse
    {
        try {
            $res = $this->accurate->get(true, 'item-category/detail.do', [], ['id' => $id]);

            if (isset($res['data']['d'])) {
                return response()->json($res['data']['d'], 200);
            }
            return response()->json(['success' => false, 'message' => 'Item category not found'], 404);
        } catch (\Throwable $e) {
            Log::error('ItemCategory@show error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     *   path="/product/item-categories",
     *   summary="Create/Update Kategori Item",
     *   description="Create jika body tanpa `id`, update jika menyertakan `id`. Dialirkan ke `item-category/save.do`.",
     *   operationId="accurateItemCategoryStore",
     *   tags={"Product: Item Categories"},
     *   security={{"BearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       oneOf={
     *         @OA\Schema(
     *           required={"name","code"},
     *           example={"name":"BEVERAGE","code":"CAT-BEV","parent":null}
     *         ),
     *         @OA\Schema(
     *           required={"id","name","code"},
     *           example={"id":101,"name":"BEVERAGE UPDATED","code":"CAT-BEV","parent":null}
     *         )
     *       }
     *     )
     *   ),
     *   @OA\Response(response=201, description="Created"),
     *   @OA\Response(response=200, description="Updated"),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=422, description="Validation Error"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $payload = $request->all();
            $response = $this->accurate->post(true, 'item-category/save.do', $payload, []);

            return response()->json($response, $response['status']);
        } catch (\Throwable $e) {
            Log::error('ItemCategory@store error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Put(
     *   path="/product/item-categories",
     *   summary="Update Kategori Item (PUT)",
     *   description="Update kategori—wajib menyertakan `id` di body. Dialirkan ke `item-category/save.do`.",
     *   operationId="accurateItemCategoryUpdate",
     *   tags={"Product: Item Categories"},
     *   security={{"BearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(type="object", example={"id":101,"name":"BEVERAGE (New)","code":"CAT-BEV","parent":null})
     *   ),
     *   @OA\Response(response=200, description="OK"),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=422, description="Validation Error"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(Request $request): JsonResponse
    {
        try {
            $payload = $request->all();
            if (empty($payload['id'])) {
                return response()->json(['success' => false, 'message' => 'ID is required for update'], 422);
            }

            $response = $this->accurate->post(true, 'item-category/save.do', $payload, []);

            return response()->json($response, $response['status']);
        } catch (\Throwable $e) {
            Log::error('ItemCategory@update error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Delete(
     *   path="/product/item-categories/{id}",
     *   summary="Hapus Kategori Item",
     *   description="Menghapus kategori berdasarkan ID internal Accurate. Dialirkan ke `item-category/delete.do` (POST) dengan `ids: [id]`.",
     *   operationId="accurateItemCategoryDestroy",
     *   tags={"Product: Item Categories"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(
     *     name="id", in="path", required=true,
     *     description="ID internal kategori di Accurate",
     *     @OA\Schema(type="integer", example=101)
     *   ),
     *   @OA\Response(
     *     response=200, description="Deleted",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Data berhasil dihapus.")
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $res = $this->accurate->post(true, 'item-category/delete.do', ['ids' => [(int) $id]], []);

            if (($res['s'] ?? false) === true) {
                return response()->json([
                    'success' => true,
                    'message' => $res['m'] ?? 'Data berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => $res['m'] ?? 'Item category not found or cannot be deleted.'
            ], 404);
        } catch (\Throwable $e) {
            Log::error('ItemCategory@destroy error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }
}
