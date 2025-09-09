<?php

namespace App\Http\Controllers\Accurate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\FormCustomerRequest;
use App\Http\Requests\Customer\IndexCustomerRequest;
use App\Support\Accurate;
use App\Docs\Accurate\CustomerSchemas; // Pastikan ini di-use

class CustomerController extends Controller
{
    protected Accurate $accurate;

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/customer",
     * summary="Mendapatkan Daftar Pelanggan",
     * description="Mengambil daftar semua pelanggan dari Accurate dengan dukungan paginasi.",
     * operationId="getCustomerList",
     * tags={"Pelanggan (Customer)"},
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
     * description="Daftar pelanggan berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/CustomerListResponse")
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
    public function index(IndexCustomerRequest $request)
    {
        $validated = $request->validated();
        $url = 'customer/list.do';
        $response = $this->accurate->get(true, $url, [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/customer/create",
     * summary="Mendapatkan Atribut Form Pembuatan Pelanggan",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan pelanggan baru.",
     * operationId="getCustomerCreateFormAttributes",
     * tags={"Pelanggan (Customer)"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/CustomerFormAttributesResponse")
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
        $csTaxTypeOptions = [
            'CTAS_KEPADA_SELAIN_PEMUNGUT_PPN',
            'CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH',
            'CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH',
            'CTAS_EKSPOR_BARANG_BERWUJUD',
            'CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD',
            'CTAS_EKSPOR_JASA',
            'CTAS_DPP_NILAI_LAIN',
            'CTAS_BESARAN_TERTENTU',
            'CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI',
            'CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT',
            'CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN',
            'CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN',
        ];
        $ContactSalutationTypeOptions = [
            'MR',
            'MRS',
        ];
        return response()->json([
            'customerTaxTypeOptions' => $csTaxTypeOptions,
            'ContactSalutationTypeOptions' => $ContactSalutationTypeOptions
        ]);
    }

    /**
     * @OA\Post(
     * path="/customer",
     * summary="Membuat atau Memperbarui Pelanggan",
     * description="Menambahkan pelanggan baru atau memperbarui data pelanggan yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdateCustomer",
     * tags={"Pelanggan (Customer)"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data pelanggan untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/CustomerInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Pelanggan berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/CustomerSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Pelanggan berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/CustomerSaveUpdateDeleteResponse")
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
    public function store(FormCustomerRequest $request)
    {
        $input = $request->validated();
        $url = 'customer/save.do'; // API Accurate yang sama untuk create dan update
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/customer/{id}",
     * summary="Mendapatkan Detail Pelanggan",
     * description="Mengambil detail lengkap satu pelanggan berdasarkan ID internalnya.",
     * operationId="getCustomerDetail",
     * tags={"Pelanggan (Customer)"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal pelanggan.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail pelanggan berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/CustomerData")
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
     * description="Pelanggan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Customer not found.")
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
        $url = 'customer/detail.do';
        $query = [
            "id" => $id
        ];
        $response = $this->accurate->get(true, $url, [], $query);
        // Accurate API returns `data.d` for detail, so we adjust the response.
        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d'], 200);
        }
        return response()->json(['message' => 'Customer not found'], 404); // Handle not found
    }

    /**
     * @OA\Get(
     * path="/customer/{id}/edit",
     * summary="Mendapatkan Detail Pelanggan dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu pelanggan berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan.",
     * operationId="getCustomerEditDataAndAttributes",
     * tags={"Pelanggan (Customer)"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal pelanggan.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail pelanggan dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/CustomerEditResponse")
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
     * description="Pelanggan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Customer not found.")
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
            $url = 'customer/detail.do';
            $query = [
                "id" => $id
            ];
            $response = $this->accurate->get(true, $url, [], $query);

            if (!isset($response['data']['d'])) { // Handle case where customer is not found by Accurate API
                return response()->json(['message' => 'Customer not found'], 404);
            }

            $csTaxTypeOptions = [
                'CTAS_KEPADA_SELAIN_PEMUNGUT_PPN',
                'CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH',
                'CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH',
                'CTAS_EKSPOR_BARANG_BERWUJUD',
                'CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD',
                'CTAS_EKSPOR_JASA',
                'CTAS_DPP_NILAI_LAIN',
                'CTAS_BESARAN_TERTENTU',
                'CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI',
                'CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT',
                'CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN',
                'CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN',
            ];
            $ContactSalutationTypeOptions = [
                'MR',
                'MRS',
            ];
            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [
                    'customerTaxTypeOptions' => $csTaxTypeOptions,
                    'ContactSalutationTypeOptions' => $ContactSalutationTypeOptions
                ]
            ]);
        } catch (\Throwable $th) {
            // Log the exception for debugging
            \Log::error("Error in CustomerController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500); // Return a generic 500
        }
    }

    // Metode update di Controller ini berfungsi sebagai POST untuk save.do (sama seperti store)
    // Jika Anda ingin metode PUT yang RESTful, Anda perlu parameter ID di URL & di metode Laravel.
    // Saat ini, diasumsikan ID ada di FormCustomerRequest dan dikirim via POST ke save.do
    /**
     * @OA\Put(
     * path="/customer",
     * summary="Memperbarui Data Pelanggan (via PUT)",
     * description="Memperbarui data pelanggan yang sudah ada. ID pelanggan harus disertakan dalam request body.",
     * operationId="updateCustomer",
     * tags={"Pelanggan (Customer)"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data pelanggan untuk diperbarui, termasuk ID pelanggan.",
     * @OA\JsonContent(ref="#/components/schemas/CustomerInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Pelanggan berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/CustomerSaveUpdateDeleteResponse")
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
     * description="Pelanggan tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Customer not found or invalid ID.")
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
    public function update(FormCustomerRequest $request)
    {
        $input = $request->validated();
        $url = 'customer/save.do'; // API Accurate yang sama untuk create dan update
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response);
    }

    /**
     * @OA\Delete(
     * path="/customer/{id}",
     * summary="Menghapus Pelanggan",
     * description="Menghapus data pelanggan berdasarkan ID internalnya.",
     * operationId="deleteCustomer",
     * tags={"Pelanggan (Customer)"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal pelanggan yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Pelanggan berhasil dihapus.",
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
     * description="Pelanggan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Customer not found or ID not valid for deletion.")
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
        $url = 'customer/delete.do';
        // Note: Accurate API expects array of IDs for delete.
        // Assuming your Accurate::delete method correctly handles this.
        $response = $this->accurate->delete(true, $url, [$id], []);

        // Accurate's response for delete might be different, adjust as needed.
        // Assuming it returns a success/message object.
        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        // Generic error if accurate API fails or customer not found
        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data pelanggan.', 'status' => false], 404);
    }
}
