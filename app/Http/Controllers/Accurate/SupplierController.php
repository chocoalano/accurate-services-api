<?php

namespace App\Http\Controllers\Accurate;

use App\Http\Controllers\Controller;
use App\Support\Accurate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Docs\Accurate\VendorSchemas;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Tag(
 *   name="Pemasok (Vendor)",
 *   description="Endpoint integrasi Vendor (Pemasok) Accurate Online"
 * )
 */
class SupplierController extends Controller
{
    protected Accurate $accurate;

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     *   path="/supplier",
     *   summary="Daftar Vendor",
     *   description="Mengambil daftar vendor dari Accurate dengan dukungan paginasi (sp.page, sp.pageSize), pencarian (sp.keyword), dan pemilihan fields.",
     *   operationId="getVendorList",
     *   tags={"Pemasok (Vendor)"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(
     *     name="page", in="query", required=false,
     *     description="Nomor halaman (default 1)",
     *     @OA\Schema(type="integer", minimum=1, example=1)
     *   ),
     *   @OA\Parameter(
     *     name="pageSize", in="query", required=false,
     *     description="Jumlah item per halaman (default 50, max 200)",
     *     @OA\Schema(type="integer", minimum=1, example=50)
     *   ),
     *   @OA\Parameter(
     *     name="keyword", in="query", required=false,
     *     description="Kata kunci pencarian (di-map ke sp.keyword)",
     *     @OA\Schema(type="string", example="PT SINERGI")
     *   ),
     *   @OA\Parameter(
     *     name="fields", in="query", required=false,
     *     description="Daftar field dipisah koma untuk optimasi payload (mis. id,name,code,phone,email)",
     *     @OA\Schema(type="string", example="id,name,code,phone,email")
     *   ),
     *   @OA\Response(
     *     response=200, description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(
     *         property="data", type="array",
     *         @OA\Items(type="object",
     *           example={
     *             "id": 501,
     *             "name": "PT Sumber Bahan Makmur",
     *             "code": "VND-0001",
     *             "phone": "021-555-1234",
     *             "email": "purchasing@sumberbahan.co.id",
     *             "address": "Jl. Industri No. 1, Jakarta",
     *             "isActive": true
     *           }
     *         )
     *       ),
     *       @OA\Property(
     *         property="meta", type="object",
     *         @OA\Property(property="page", type="integer", example=1),
     *         @OA\Property(property="pageSize", type="integer", example=50),
     *         @OA\Property(property="total", type="integer", nullable=true, example=240)
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

            // GET ke Accurate
            $res = $this->accurate->get(true, 'vendor/list.do', [], $query);

            return response()->json([
                'success' => true,
                'data'    => $res['data']['d'] ?? [],
                'meta'    => [
                    'page'     => $page,
                    'pageSize' => $pageSize,
                    'total'    => $res['data']['sp']['rowCount'] ?? null,
                ],
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Vendor@index error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     *   path="/supplier",
     *   summary="Create/Update Vendor",
     *   description="Create jika body **tanpa** `id`, update jika **menyertakan** `id`. Dialirkan ke Accurate `vendor/save.do`.",
     *   operationId="createOrUpdateVendor",
     *   tags={"Pemasok (Vendor)"},
     *   security={{"BearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       oneOf={
     *         @OA\Schema(
     *           required={"name"},
     *           example={
     *              "name": "PT. Halo Semua 123",
     *              "transDate": "31/03/2016",
     *              "billCity": "Jakarta",
     *              "billCountry": "Indonesia",
     *              "billProvince": "DKI Jakarta",
     *              "billStreet": "Jl. Sudirman No. 123",
     *              "billZipCode": "12345",
     *              "branchId": 1,
     *              "branchName": "Cabang Pusat",
     *              "categoryName": "Pemasok Bahan",
     *              "currencyCode": "IDR",
     *              "defaultIncTax": true,
     *              "description": "Vendor percobaan Accurate API",
     *              "email": "vendor@example.com",
     *              "fax": "021-1234567",
     *              "mobilePhone": "08123456789",
     *              "notes": "Catatan tambahan",
     *              "npwpNo": "12.345.678.9-012.345",
     *              "number": "VN-0001",
     *              "pkpNo": "PKP-98765",
     *              "taxCity": "Jakarta",
     *              "taxCountry": "Indonesia",
     *              "taxProvince": "DKI Jakarta",
     *              "taxSameAsBill": true,
     *              "taxStreet": "Jl. Gatot Subroto No. 45",
     *              "taxZipCode": "54321",
     *              "termName": "Net 30",
     *              "typeAutoNumber": 2,
     *              "vendorNo": "VND-001",
     *              "vendorTaxType": "TAX",
     *              "website": "http://contohvndr.com",
     *              "workPhone": "021-9876543",
     *              "wpName": "Wajib Pajak Vendor",
     *              "detailContact": {
     *                  {
     *                      "bbmPin": "BBM12345",
     *                      "email": "kontak1@example.com",
     *                      "fax": "021-000111",
     *                      "homePhone": "021-999888",
     *                      "id": 1,
     *                      "mobilePhone": "0812000111",
     *                      "name": "John Doe",
     *                      "notes": "Kontak utama",
     *                      "position": "Manager",
     *                      "salutation": "Bapak",
     *                      "website": "http://john.com",
     *                      "workPhone": "021-111222"
     *                  }
     *              },
     *              "detailOpenBalance": {
     *                  {
     *                      "_status": "",
     *                      "amount": 95275.12,
     *                      "asOf": "31/03/2016",
     *                      "currencyCode": "IDR",
     *                      "description": "Saldo awal hutang",
     *                      "id": 10,
     *                      "number": "OB-001",
     *                      "paymentTermName": "Net 30",
     *                      "rate": 1,
     *                      "typeAutoNumber": 1
     *                  }
     *              }
     *            }
     *         ),
     *         @OA\Schema(
     *           required={"id","name"},
     *           example={
     *             "id": 501,
     *             "name": "PT Sumber Bahan Makmur (Updated)",
     *             "phone": "021-555-5678",
     *             "isActive": true
     *           }
     *         )
     *       }
     *     )
     *   ),
     *   @OA\Response(
     *     response=201, description="Created",
     *     @OA\JsonContent(type="object",
     *       example={
     *         "success": true,
     *         "message": "Created",
     *         "data": {"id": 602, "name": "PT Sumber Bahan Makmur", "code": "VND-0001"}
     *       }
     *     )
     *   ),
     *   @OA\Response(
     *     response=200, description="Updated",
     *     @OA\JsonContent(type="object",
     *       example={
     *         "success": true,
     *         "message": "Updated",
     *         "data": {"id": 501, "name": "PT Sumber Bahan Makmur (Updated)"}
     *       }
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=422, description="Validation Error"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        try {
            // Validasi ringan (opsional: buat FormRequest khusus Vendor)
            $payload = $request->all();
            if (empty($payload['name'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Field "name" wajib diisi.'
                ], 422);
            }
            $response = $this->accurate->post(true, 'vendor/save.do', $payload, []);
            return response()->json($response, $response['status']);
        } catch (\Throwable $e) {
            Log::error('Vendor@store error', ['e' => $e, 'payload' => $request->all()]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/supplier/{id}",
     *   summary="Detail Vendor",
     *   description="Mengambil detail vendor berdasarkan ID internal Accurate.",
     *   operationId="getVendorDetail",
     *   tags={"Pemasok (Vendor)"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(
     *     name="id", in="path", required=true,
     *     description="ID internal vendor di Accurate",
     *     @OA\Schema(type="integer", example=501)
     *   ),
     *   @OA\Response(
     *     response=200, description="OK",
     *     @OA\JsonContent(type="object",
     *       example={
     *         "id": 501,
     *         "name": "PT Sumber Bahan Makmur",
     *         "code": "VND-0001",
     *         "phone": "021-555-1234",
     *         "email": "purchasing@sumberbahan.co.id",
     *         "address": "Jl. Industri No. 1, Jakarta",
     *         "isActive": true
     *       }
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function show(string $id): JsonResponse
    {
        try {
            $res = $this->accurate->get(true, 'vendor/detail.do', [], ['id' => $id]);

            if (isset($res['data']['d'])) {
                return response()->json($res['data']['d'], 200);
            }
            return response()->json(['success' => false, 'message' => 'Vendor not found'], 404);
        } catch (\Throwable $e) {
            Log::error('Vendor@show error', ['e' => $e, 'id' => $id]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Put(
     *   path="/supplier",
     *   summary="Update Vendor (PUT)",
     *   description="Memperbarui vendor—wajib menyertakan `id` di body. Dialirkan ke Accurate `vendor/save.do`.",
     *   operationId="updateVendor",
     *   tags={"Pemasok (Vendor)"},
     *   security={{"BearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"id","name"},
     *       example={
     *         "id": 501,
     *         "name": "PT Sumber Bahan Makmur (Updated)",
     *         "phone": "021-555-5678",
     *         "email": "purchasing@sumberbahan.co.id"
     *       }
     *     )
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
            if (empty($payload['name'])) {
                return response()->json(['success' => false, 'message' => 'Field "name" wajib diisi.'], 422);
            }

            $response = $this->accurate->post(true, 'vendor/save.do', $payload, []);

            return response()->json($response, $response['status']);
        } catch (\Throwable $e) {
            Log::error('Vendor@update error', ['e' => $e, 'payload' => $request->all()]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Delete(
     *   path="/supplier/{id}",
     *   summary="Hapus Vendor",
     *   description="Menghapus vendor berdasarkan ID internal Accurate. Di Accurate dilakukan via `vendor/delete.do` (POST) dengan payload `ids: [id]`.",
     *   operationId="deleteVendor",
     *   tags={"Pemasok (Vendor)"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(
     *     name="id", in="path", required=true,
     *     description="ID internal vendor di Accurate",
     *     @OA\Schema(type="integer", example=501)
     *   ),
     *   @OA\Response(
     *     response=200, description="Deleted",
     *     @OA\JsonContent(type="object",
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
            // Accurate delete.do memakai POST { ids: [...] }
            $res = $this->accurate->post(true, 'vendor/delete.do', ['ids' => [(int) $id]], []);

            if (($res['s'] ?? false) === true) {
                return response()->json([
                    'success' => true,
                    'message' => $res['m'] ?? 'Data berhasil dihapus.'
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => $res['m'] ?? 'Vendor not found or cannot be deleted.'
            ], 404);
        } catch (\Throwable $e) {
            Log::error('Vendor@destroy error', ['e' => $e, 'id' => $id]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }
}
