<?php

namespace App\Http\Controllers\Accurate\Item;

use App\Http\Controllers\Controller;
use App\Support\Accurate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Docs\Accurate\Product\ItemSchemas;

/**
 * @OA\Tag(
 *   name="Product: Items",
 *   description="Endpoint integrasi Item (Barang & Jasa) Accurate Online"
 * )
 */
class ItemController extends Controller
{
    public function __construct(protected Accurate $accurate)
    {
    }

    /**
     * @OA\Get(
     *   path="/product/item",
     *   summary="Daftar Item (Barang & Jasa)",
     *   description="Ambil daftar item dari Accurate dengan paginasi, pencarian, fields, & filter.* (mis. filter.itemType=INVENTORY).",
     *   operationId="accurateItemIndex",
     *   tags={"Product: Items"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(name="page", in="query", description="Nomor halaman (default 1)", @OA\Schema(type="integer", minimum=1, example=1)),
     *   @OA\Parameter(name="pageSize", in="query", description="Jumlah per halaman (default 50, max 200)", @OA\Schema(type="integer", minimum=1, example=50)),
     *   @OA\Parameter(name="keyword", in="query", description="Kata kunci (sp.keyword)", @OA\Schema(type="string", example="MATCHA")),
     *   @OA\Parameter(name="fields", in="query", description="Daftar field dipisah koma (mis. id,name,no)", @OA\Schema(type="string", example="id,name,no")),
     *   @OA\Parameter(name="filter.itemType", in="query", description="Filter tipe item (INVENTORY / SERVICE)", @OA\Schema(type="string", example="INVENTORY")),
     *   @OA\Parameter(name="filter.isActive", in="query", description="Filter aktif (true/false)", @OA\Schema(type="string", example="true")),
     *   @OA\Response(
     *     response=200, description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="data", type="array", @OA\Items(type="object")),
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
                'sp.page' => $page,
                'sp.pageSize' => $pageSize,
            ];

            if ($kw = $request->query('keyword')) {
                $query['sp.keyword'] = $kw;
            }
            // Passthrough beberapa query yang umum dipakai pada AOL item/list.do
            if ($fields = $request->query('fields')) {
                $query['fields'] = $fields; // contoh: id,name,no
            }
            foreach ($request->query() as $k => $v) {
                if (str_starts_with($k, 'filter.')) {
                    $query[$k] = $v; // contoh: filter.itemType=INVENTORY
                }
            }

            $res = $this->accurate->get(true, 'item/list.do', [], $query);

            return response()->json([
                'success' => true,
                'data' => $res['data']['d'] ?? [],
                'meta' => [
                    'page' => $page,
                    'pageSize' => $pageSize,
                    'total' => $res['data']['sp']['rowCount'] ?? null,
                ],
            ]);
        } catch (\Throwable $e) {
            \Log::error('Item@index error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/product/item/{id}/nearest-cost",
     *   summary="Nearest Cost (Item)",
     *   description="Mengambil biaya terdekat (nearest cost) untuk sebuah Item dari Accurate. Dapat difilter dengan tanggal dan/atau gudang.",
     *   operationId="accurateItemNearestCost",
     *   tags={"Product: Items"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID internal Item di Accurate",
     *     @OA\Schema(type="integer", example=101)
     *   ),
     *   @OA\Parameter(
     *     name="date",
     *     in="query",
     *     required=false,
     *     description="Tanggal acuan (YYYY-MM-DD)",
     *     @OA\Schema(type="string", format="date", example="2025-09-01")
     *   ),
     *   @OA\Parameter(
     *     name="warehouseId",
     *     in="query",
     *     required=false,
     *     description="ID gudang (opsional) untuk menghitung biaya terdekat per gudang",
     *     @OA\Schema(type="integer", example=12)
     *   ),
     *   @OA\Parameter(
     *     name="qty",
     *     in="query",
     *     required=false,
     *     description="Kuantitas (opsional) bila perhitungan biaya mempertimbangkan jumlah",
     *     @OA\Schema(type="number", format="float", example=5)
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       example={
     *         "cost": 98765.43,
     *         "currency": "IDR",
     *         "asOfDate": "2025-09-01",
     *         "warehouseId": 12,
     *         "method": "nearest"
     *       }
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function nearestCost(string $id): JsonResponse
    {
        try {
            // Query wajib
            $query = ['id' => $id];

            // Passthrough parameter opsional dari request
            $req = request();
            foreach (['date', 'warehouseId', 'qty'] as $k) {
                $v = $req->query($k);
                if ($v !== null && $v !== '') {
                    $query[$k] = $v;
                }
            }

            // Panggil Accurate 5
            $res = $this->accurate->get(true, 'item/get-nearest-cost.do', [], $query);

            if (isset($res['data']['d'])) {
                return response()->json($res['data']['d'], 200);
            }

            return response()->json(['success' => false, 'message' => 'Item or nearest cost not found'], 404);
        } catch (\Throwable $e) {
            \Log::error('Item@nearestCost error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/product/item/{id}/selling-price",
     *   summary="Selling Price (Item)",
     *   description="Mengambil harga jual (selling price) untuk sebuah Item dari Accurate. Dapat dipengaruhi oleh level harga, pelanggan, kuantitas, tanggal, gudang, dan mata uang.",
     *   operationId="accurateItemSellingPrice",
     *   tags={"Product: Items"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID internal Item di Accurate",
     *     @OA\Schema(type="integer", example=101)
     *   ),
     *   @OA\Parameter(
     *     name="date",
     *     in="query",
     *     required=false,
     *     description="Tanggal acuan (YYYY-MM-DD)",
     *     @OA\Schema(type="string", format="date", example="2025-09-01")
     *   ),
     *   @OA\Parameter(
     *     name="customerId",
     *     in="query",
     *     required=false,
     *     description="ID pelanggan (jika harga dipengaruhi customer/kontrak)",
     *     @OA\Schema(type="integer", example=555)
     *   ),
     *   @OA\Parameter(
     *     name="priceCategoryId",
     *     in="query",
     *     required=false,
     *     description="ID kategori/level harga (Price Category)",
     *     @OA\Schema(type="integer", example=3)
     *   ),
     *   @OA\Parameter(
     *     name="qty",
     *     in="query",
     *     required=false,
     *     description="Kuantitas (jika ada tier/quantity break)",
     *     @OA\Schema(type="number", format="float", example=10)
     *   ),
     *   @OA\Parameter(
     *     name="currency",
     *     in="query",
     *     required=false,
     *     description="Kode mata uang (mis. IDR, USD)",
     *     @OA\Schema(type="string", example="IDR")
     *   ),
     *   @OA\Parameter(
     *     name="warehouseId",
     *     in="query",
     *     required=false,
     *     description="ID gudang (bila harga mempertimbangkan gudang)",
     *     @OA\Schema(type="integer", example=12)
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       example={
     *         "price": 125000.00,
     *         "currency": "IDR",
     *         "priceCategoryId": 3,
     *         "priceCategoryName": "Retail",
     *         "customerId": 555,
     *         "qty": 10,
     *         "asOfDate": "2025-09-01",
     *         "warehouseId": 12,
     *         "source": "price-category"
     *       }
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function sellingPrice(string $id): JsonResponse
    {
        try {
            // Query wajib
            $query = ['id' => $id];

            // Passthrough parameter opsional yang umum dipakai Accurate 5
            $req = request();
            foreach (['date', 'customerId', 'priceCategoryId', 'qty', 'currency', 'warehouseId'] as $k) {
                $v = $req->query($k);
                if ($v !== null && $v !== '') {
                    $query[$k] = $v;
                }
            }

            // Panggil Accurate 5
            $res = $this->accurate->get(true, 'item/get-selling-price.do', [], $query);

            if (isset($res['data']['d'])) {
                return response()->json($res['data']['d'], 200);
            }

            return response()->json(['success' => false, 'message' => 'Selling price not found'], 404);
        } catch (\Throwable $e) {
            \Log::error('Item@sellingPrice error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/product/item/{id}/stock",
     *   summary="Stock Item",
     *   description="Mengambil informasi stok suatu Item di Accurate. Bisa difilter dengan gudang dan tanggal.",
     *   operationId="accurateItemStock",
     *   tags={"Product: Items"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID internal Item di Accurate",
     *     @OA\Schema(type="integer", example=101)
     *   ),
     *   @OA\Parameter(
     *     name="warehouseId",
     *     in="query",
     *     required=false,
     *     description="ID gudang (opsional) untuk stok per gudang",
     *     @OA\Schema(type="integer", example=12)
     *   ),
     *   @OA\Parameter(
     *     name="date",
     *     in="query",
     *     required=false,
     *     description="Tanggal acuan stok (YYYY-MM-DD). Default: hari ini.",
     *     @OA\Schema(type="string", format="date", example="2025-09-10")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       example={
     *         "itemId": 101,
     *         "warehouseId": 12,
     *         "warehouseName": "Gudang Utama",
     *         "stock": 150,
     *         "reserved": 20,
     *         "available": 130,
     *         "asOfDate": "2025-09-10"
     *       }
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function stock(string $id): JsonResponse
    {
        try {
            // Query wajib
            $query = ['id' => $id];

            // Passthrough parameter opsional
            $req = request();
            foreach (['warehouseId', 'date'] as $k) {
                $v = $req->query($k);
                if ($v !== null && $v !== '') {
                    $query[$k] = $v;
                }
            }

            // Call Accurate 5 API
            $res = $this->accurate->get(true, 'item/get-stock.do', [], $query);

            if (isset($res['data']['d'])) {
                return response()->json($res['data']['d'], 200);
            }

            return response()->json(['success' => false, 'message' => 'Stock not found'], 404);
        } catch (\Throwable $e) {
            \Log::error('Item@stock error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/product/item/{id}/stock-mutation-history",
     *   summary="Stock Mutation History (Item)",
     *   description="Mengambil riwayat mutasi stok (masuk/keluar/penyesuaian) untuk sebuah Item dari Accurate. Bisa difilter tanggal dan gudang, serta dipaginasi.",
     *   operationId="accurateItemStockMutationHistory",
     *   tags={"Product: Items"},
     *   security={{"BearerAuth": {}}},
     *
     *   @OA\Parameter(
     *     name="id", in="path", required=true,
     *     description="ID internal Item di Accurate",
     *     @OA\Schema(type="integer", example=101)
     *   ),
     *   @OA\Parameter(
     *     name="startDate", in="query", required=false,
     *     description="Tanggal mulai rentang (YYYY-MM-DD)",
     *     @OA\Schema(type="string", format="date", example="2025-09-01")
     *   ),
     *   @OA\Parameter(
     *     name="endDate", in="query", required=false,
     *     description="Tanggal akhir rentang (YYYY-MM-DD)",
     *     @OA\Schema(type="string", format="date", example="2025-09-10")
     *   ),
     *   @OA\Parameter(
     *     name="warehouseId", in="query", required=false,
     *     description="ID gudang (opsional) untuk membatasi mutasi pada gudang tertentu",
     *     @OA\Schema(type="integer", example=12)
     *   ),
     *   @OA\Parameter(
     *     name="page", in="query", required=false,
     *     description="Nomor halaman (default 1)",
     *     @OA\Schema(type="integer", minimum=1, example=1)
     *   ),
     *   @OA\Parameter(
     *     name="pageSize", in="query", required=false,
     *     description="Jumlah baris per halaman (default 50, max 200)",
     *     @OA\Schema(type="integer", minimum=1, example=50)
     *   ),
     *
     *   @OA\Response(
     *     response=200, description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(
     *           type="object",
     *           example={
     *             "date": "2025-09-05",
     *             "warehouseId": 12,
     *             "warehouseName": "Gudang Utama",
     *             "docType": "Sales Delivery",
     *             "docNo": "SD-000123",
     *             "reference": "Pengiriman 000123",
     *             "qtyIn": 0,
     *             "qtyOut": 5,
     *             "balance": 125,
     *             "remarks": "Kirim ke customer A"
     *           }
     *         )
     *       ),
     *       @OA\Property(
     *         property="meta",
     *         type="object",
     *         @OA\Property(property="page", type="integer", example=1),
     *         @OA\Property(property="pageSize", type="integer", example=50),
     *         @OA\Property(property="total", type="integer", nullable=true, example=240)
     *       )
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function stockMutationHistory(string $id): JsonResponse
    {
        try {
            // Wajib
            $query = ['id' => $id];

            // Opsi umum Accurate 5 untuk endpoint ini
            $req = request();
            $page = (int) $req->query('page', 1);
            $pageSize = (int) $req->query('pageSize', 50);
            $pageSize = min(max($pageSize, 1), 200);

            // Accurate memakai namespace sp.* untuk pagination
            $query['sp.page'] = $page;
            $query['sp.pageSize'] = $pageSize;

            // Filter tanggal & gudang (opsional)
            foreach (['startDate', 'endDate', 'warehouseId'] as $k) {
                $v = $req->query($k);
                if ($v !== null && $v !== '') {
                    $query[$k] = $v;
                }
            }

            // Panggil Accurate 5
            $res = $this->accurate->get(true, 'item/stock-mutation-history.do', [], $query);

            // Pola respons umum AOL: { s, m, data: { d: [...], sp: {...} } }
            $rows = $res['data']['d'] ?? null;
            if (is_array($rows)) {
                return response()->json([
                    'success' => true,
                    'data' => $rows,
                    'meta' => [
                        'page' => $page,
                        'pageSize' => $pageSize,
                        'total' => $res['data']['sp']['rowCount'] ?? null,
                    ],
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Mutation history not found',
            ], 404);
        } catch (\Throwable $e) {
            \Log::error('Item@stockMutationHistory error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/product/item/{id}/vendor-prices",
     *   summary="Vendor Prices (Item)",
     *   description="Mengambil daftar harga vendor (Vendor Price) untuk sebuah Item dari Accurate. Mendukung filter vendor, unit, dan pagination.",
     *   operationId="accurateItemVendorPrices",
     *   tags={"Product: Items"},
     *   security={{"BearerAuth": {}}},
     *
     *   @OA\Parameter(
     *     name="id", in="path", required=true,
     *     description="ID internal Item di Accurate",
     *     @OA\Schema(type="integer", example=12345)
     *   ),
     *   @OA\Parameter(
     *     name="vendorId", in="query", required=false,
     *     description="Filter berdasarkan vendor pemasok",
     *     @OA\Schema(type="integer", example=67890)
     *   ),
     *   @OA\Parameter(
     *     name="unit", in="query", required=false,
     *     description="Filter satuan (isi jika item multi-unit)",
     *     @OA\Schema(type="string", example="PCS")
     *   ),
     *   @OA\Parameter(
     *     name="activeOnly", in="query", required=false,
     *     description="True untuk hanya harga yang masih aktif (tanpa expired atau belum kedaluwarsa)",
     *     @OA\Schema(type="boolean", example=true)
     *   ),
     *   @OA\Parameter(
     *     name="page", in="query", required=false,
     *     description="Nomor halaman (default 1)",
     *     @OA\Schema(type="integer", minimum=1, example=1)
     *   ),
     *   @OA\Parameter(
     *     name="pageSize", in="query", required=false,
     *     description="Jumlah baris per halaman (default 50, max 200)",
     *     @OA\Schema(type="integer", minimum=1, example=50)
     *   ),
     *
     *   @OA\Response(
     *     response=200, description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(
     *           type="object",
     *           example={
     *             "id": 991122,
     *             "itemId": 12345,
     *             "vendorId": 67890,
     *             "unit": "PCS",
     *             "price": 14500.0,
     *             "currency": "IDR",
     *             "minQty": 1,
     *             "effectiveDate": "2025-09-01",
     *             "expiredDate": null,
     *             "notes": "Harga kontrak Q4 2025"
     *           }
     *         )
     *       ),
     *       @OA\Property(
     *         property="meta",
     *         type="object",
     *         @OA\Property(property="page", type="integer", example=1),
     *         @OA\Property(property="pageSize", type="integer", example=50),
     *         @OA\Property(property="total", type="integer", nullable=true, example=240)
     *       )
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function vendorPrices(string $id): JsonResponse
    {
        try {
            // Wajib: Item ID
            $query = ['itemId' => $id];

            // Paging
            $req = request();
            $page = (int) $req->query('page', 1);
            $pageSize = (int) $req->query('pageSize', 50);
            $pageSize = min(max($pageSize, 1), 200);

            $query['sp.page'] = $page;
            $query['sp.pageSize'] = $pageSize;

            // Filter opsional (sesuaikan dengan dokumen Accurate Anda)
            $allowedFilters = ['vendorId', 'unit', 'activeOnly'];
            foreach ($allowedFilters as $k) {
                $v = $req->query($k);
                if ($v !== null && $v !== '') {
                    $query[$k] = $v;
                }
            }

            // Panggil Accurate 5: item/vendor-price.do
            // $this->accurate->get(bool $needSession, string $path, array $headers = [], array $query = [])
            $res = $this->accurate->get(true, 'item/vendor-price.do', [], $query);

            // Pola respons umum AOL: { s, m, data: { d: [...], sp: {...} } }
            $rows = $res['data']['d'] ?? null;

            if (is_array($rows)) {
                return response()->json([
                    'success' => true,
                    'data' => $rows,
                    'meta' => [
                        'page' => $page,
                        'pageSize' => $pageSize,
                        'total' => $res['data']['sp']['rowCount'] ?? null,
                    ],
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => 'Vendor prices not found',
            ], 404);

        } catch (\Throwable $e) {
            \Log::error('Item@vendorPrices error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Get(
     *   path="/product/item/{id}",
     *   summary="Detail Item",
     *   description="Ambil detail satu item berdasarkan ID internal Accurate.",
     *   operationId="accurateItemShow",
     *   tags={"Product: Items"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", example="101")),
     *   @OA\Response(response=200, description="OK", @OA\JsonContent(type="object")),
     *   @OA\Response(response=401, description="Unauthenticated"),
     *   @OA\Response(response=404, description="Not Found"),
     *   @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function show(string $id): JsonResponse
    {
        try {
            $res = $this->accurate->get(true, 'item/detail.do', [], ['id' => $id]);
            if (isset($res['data']['d'])) {
                return response()->json($res['data']['d']);
            }
            return response()->json(['success' => false, 'message' => 'Item not found'], 404);
        } catch (\Throwable $e) {
            \Log::error('Item@show error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     *   path="/product/item",
     *   summary="Create/Update Item",
     *   description="Create jika tanpa `id`, update jika menyertakan `id`. Accurate memakai endpoint yang sama `item/save.do`.",
     *   operationId="accurateItemStore",
     *   tags={"Product: Items"},
     *   security={{"BearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       example={"name":"Matcha 1kg","code":"SKU-MATCHA-1KG","itemType":"INVENTORY","unit":"KG","salesPrice":125000}
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
            $payload = $request->all(); // validasi sesuai kebutuhanmu
            $res = $this->accurate->post(true, 'item/save.do', $payload, []);
            $created = empty($payload['id'] ?? null);

            return response()->json([
                'success' => (bool) ($res['s'] ?? false),
                'message' => $res['m'] ?? ($created ? 'Created' : 'Updated'),
                'data' => $res['d'] ?? null,
            ], $created ? 201 : 200);
        } catch (\Throwable $e) {
            \Log::error('Item@store error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Put(
     *   path="/product/item",
     *   summary="Update Item (PUT)",
     *   description="Update item—wajib menyertakan `id` di body.",
     *   operationId="accurateItemUpdate",
     *   tags={"Product: Items"},
     *   security={{"BearerAuth": {}}},
     *   @OA\RequestBody(required=true, @OA\JsonContent(type="object", example={"id":101,"name":"Matcha 1kg (New)"})),
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
            $res = $this->accurate->post(true, 'item/save.do', $payload, []);

            return response()->json([
                'success' => (bool) ($res['s'] ?? false),
                'message' => $res['m'] ?? 'Updated',
                'data' => $res['d'] ?? null,
            ]);
        } catch (\Throwable $e) {
            \Log::error('Item@update error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Delete(
     *   path="/product/item/{id}",
     *   summary="Hapus Item",
     *   description="Menghapus item berdasarkan ID internal Accurate.",
     *   operationId="accurateItemDestroy",
     *   tags={"Product: Items"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", example="101")),
     *   @OA\Response(response=200, description="Deleted",
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
            // AOL delete.do ⇒ POST { ids: [ ... ] }
            $res = $this->accurate->post(true, 'item/delete.do', ['ids' => [(int) $id]], []);

            if (($res['s'] ?? false) === true) {
                return response()->json(['success' => true, 'message' => $res['m'] ?? 'Data berhasil dihapus.'], 200);
            }
            return response()->json(['success' => false, 'message' => $res['m'] ?? 'Item not found or cannot be deleted.'], 404);
        } catch (\Throwable $e) {
            \Log::error('Item@destroy error', ['e' => $e]);
            return response()->json(['success' => false, 'message' => 'Internal Server Error'], 500);
        }
    }
}
