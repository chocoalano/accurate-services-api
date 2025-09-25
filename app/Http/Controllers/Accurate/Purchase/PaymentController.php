<?php

namespace App\Http\Controllers\Accurate\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\Payment\FormRequest;
use App\Http\Requests\Purchase\Payment\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\Purchase\PaymentSchemas; // Pastikan ini di-use
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected Accurate $accurate;
    protected $payment_method;

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
        $this->payment_method = [
            'BANK_CHEQUE',
            'BANK_TRANSFER',
            'CASH_OTHER',
            'EDC',
            'OTHERS',
            'PAYMENT_LINK',
            'QRIS',
            'VIRTUAL_ACCOUNT'
        ];
    }
    /**
     * @OA\Get(
     * path="/purchase/payment",
     * summary="Mendapatkan Daftar Pembayaran Pembelian",
     * description="Mengambil daftar semua pembayaran pembelian dari Accurate dengan dukungan paginasi.",
     * operationId="getPurchasePaymentList",
     * tags={"Purchase: Payment"},
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
     * description="Daftar pembayaran pembelian berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchasePaymentListResponse")
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
        $url = 'purchase-payment/list.do';
        $response = $this->accurate->get(true, $url, [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/purchase/payment/create",
     * summary="Mendapatkan Atribut Form Pembuatan Pembayaran Pembelian",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan pembayaran pembelian baru, seperti metode pembayaran.",
     * operationId="getPurchasePaymentCreateFormAttributes",
     * tags={"Purchase: Payment"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Atribut form berhasil diambil.",
     * @OA\JsonContent(
     * @OA\Property(property="payment_method", type="array", @OA\Items(type="string", enum={"BANK_CHEQUE", "BANK_TRANSFER", "CASH_OTHER", "EDC", "OTHERS", "PAYMENT_LINK", "QRIS", "VIRTUAL_ACCOUNT"}), description="Opsi metode pembayaran.")
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
            'payment_method' => $this->payment_method
        ]);
    }

    /**
     * @OA\Post(
     * path="/purchase/payment",
     * summary="Membuat atau Memperbarui Pembayaran Pembelian",
     * description="Menambahkan pembayaran pembelian baru atau memperbarui data pembayaran pembelian yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdatePurchasePayment",
     * tags={"Purchase: Payment"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data pembayaran pembelian untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/PurchasePaymentInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Pembayaran pembelian berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/PurchasePaymentSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Pembayaran pembelian berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/PurchasePaymentSaveUpdateDeleteResponse")
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
        $url = 'purchase-payment/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, $response['status']);
    }

    /**
     * @OA\Get(
     * path="/purchase/payment/{id}",
     * summary="Mendapatkan Detail Pembayaran Pembelian",
     * description="Mengambil detail lengkap satu pembayaran pembelian berdasarkan ID internalnya.",
     * operationId="getPurchasePaymentDetail",
     * tags={"Purchase: Payment"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal pembayaran pembelian.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail pembayaran pembelian berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchasePaymentData")
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
     * description="Pembayaran pembelian tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Payment not found.")
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
        $url = 'purchase-payment/detail.do';
        $query = [
            "id" => $id
        ];
        $response = $this->accurate->get(true, $url, [], $query);
        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Purchase Payment not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/purchase/payment/{id}/edit",
     * summary="Mendapatkan Detail Pembayaran Pembelian dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu pembayaran pembelian berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan.",
     * operationId="getPurchasePaymentEditDataAndAttributes",
     * tags={"Purchase: Payment"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal pembayaran pembelian.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail pembayaran pembelian dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/PurchasePaymentEditResponse")
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
     * description="Pembayaran pembelian tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Payment not found.")
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
            $url = 'purchase-payment/detail.do';
            $query = [
                "id" => $id
            ];
            $response = $this->accurate->get(true, $url, [], $query);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Purchase Payment not found'], 404);
            }

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [
                    'payment_method' => $this->payment_method
                ]
            ]);
        } catch (\Throwable $th) {
            Log::error("Error in PaymentController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/purchase/payment",
     * summary="Memperbarui Data Pembayaran Pembelian (via POST)",
     * description="Memperbarui data pembayaran pembelian yang sudah ada. ID pembayaran pembelian harus disertakan dalam request body.",
     * operationId="updatePurchasePayment",
     * tags={"Purchase: Payment"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data pembayaran pembelian untuk diperbarui, termasuk ID.",
     * @OA\JsonContent(ref="#/components/schemas/PurchasePaymentInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Pembayaran pembelian berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/PurchasePaymentSaveUpdateDeleteResponse")
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
     * description="Pembayaran pembelian tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Payment not found or invalid ID.")
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
        $url = 'purchase-payment/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, $response['status']);
    }

    /**
     * @OA\Delete(
     * path="/purchase/payment/{id}",
     * summary="Menghapus Pembayaran Pembelian",
     * description="Menghapus data pembayaran pembelian berdasarkan ID internalnya.",
     * operationId="deletePurchasePayment",
     * tags={"Purchase: Payment"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal pembayaran pembelian yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Pembayaran pembelian berhasil dihapus.",
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
     * description="Pembayaran pembelian tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Purchase Payment not found or ID not valid for deletion.")
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
        $url = 'purchase-payment/delete.do';
        $response = $this->accurate->delete(true, $url, [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data pembayaran pembelian.', 'status' => false], 404);
    }
}
