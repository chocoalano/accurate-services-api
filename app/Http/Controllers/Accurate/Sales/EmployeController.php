<?php

namespace App\Http\Controllers\Accurate\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employe\FormRequest;
use App\Http\Requests\Employe\IndexRequest;
use App\Support\Accurate;
use App\Docs\Accurate\EmployeSchemas; // Pastikan ini di-use

class EmployeController extends Controller
{
    protected Accurate $accurate;
    private array $salutationType = [
        'MR',
        'MRS',
    ];
    private array $domisiliType = [
        'ARE', 'AUS', 'AUT', 'BEL', 'BGD', 'BGR', 'BRN', 'CAN', 'CHE', 'CHN', 'CZE', 'DEU', 'DNK', 'DZA', 'EGY', 'ESP', 'FIN', 'FRA', 'GBR', 'HKG', 'HUN', 'INA', 'IND', 'IRN', 'ITA', 'JOR', 'JPN', 'KOR', 'KWT', 'LKA', 'LUX', 'MAR', 'MNG', 'MYS', 'NLD', 'NOR', 'NZL', 'PAK', 'PHL', 'POL', 'PRK', 'PRT', 'QAT', 'ROU', 'RUS', 'SAU', 'SDN', 'SGP', 'SVK', 'SWE', 'SYC', 'SYR', 'THA', 'TUN', 'TUR', 'TWN', 'UKR', 'USA', 'UZB', 'VEN', 'VNM', 'ZAF',
    ];

    private array $employeeTaxStatusType = [
        'K0', 'K1', 'K2', 'K3', 'TK0', 'TK1', 'TK2', 'TK3',
    ];

    private array $employeeWorkStatusType = [
        'ANGGOTA_DEWAN_KOMISARIS', 'BUKAN_PEGAWAI_BUKAN_PEGAWAI_IMBALAN_SINAMBUNGAN', 'BUKAN_PEGAWAI_BUKAN_PEGAWAI_IMBALAN_TIDAK_SINAMBUNGAN', 'BUKAN_PEGAWAI_DISTRIBUTOR_MLM', 'BUKAN_PEGAWAI_PENJAJA_DAGANGAN', 'BUKAN_PEGAWAI_PETUGAS_ASURANSI', 'BUKAN_PEGAWAI_TENAGA_AHLI', 'MANTAN_PEGAWAI_TERIMA_IMBALAN', 'PEGAWAI_TARIK_PENSIUN', 'PEGAWAI_TETAP', 'PEGAWAI_TIDAK_TETAP', 'PEGAWAI_WAJIB_PAJAK_LUAR_NEGERI', 'PENERIMA_MANFAAT_DIBAYARKAN_SEKALIGUS', 'PENERIMA_PENGHASILAN_DIPOTONG_PPH21_FINAL', 'PENERIMA_PENGHASILAN_DIPOTONG_PPH21_TIDAK_FINAL', 'PENERIMA_PENSIUN_BERKALA', 'PENERIMA_PESANGON_SEKALIGUS', 'PESERTA_KEGIATAN',
    ];

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;
    }

    /**
     * @OA\Get(
     * path="/sales-employee",
     * summary="Mendapatkan Daftar Karyawan",
     * description="Mengambil daftar semua karyawan dari Accurate dengan dukungan paginasi.",
     * operationId="getEmployeList",
     * tags={"Karyawan"},
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
     * description="Daftar karyawan berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/EmployeListResponse")
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
        $response = $this->accurate->get(true, 'employee/list.do', [], [
            'sp.page' => $validated['page'],
            'sp.pageSize' => $validated['pageSize'],
        ]);

        return response()->json($response);
    }

    /**
     * @OA\Get(
     * path="/sales-employee/create",
     * summary="Mendapatkan Atribut Form Pembuatan Karyawan",
     * description="Mengambil daftar opsi dan atribut yang diperlukan untuk mengisi form pembuatan karyawan baru, seperti tipe sapaan, domisili, status pajak, status pekerjaan, cabang, dan departemen.",
     * operationId="getEmployeCreateFormAttributes",
     * tags={"Karyawan"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/EmployeFormAttributesResponse")
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
        $branch = $this->accurate->get(true, 'branch/list.do');
        $departement = $this->accurate->get(true, 'department/list.do');
        return response()->json([
            "salutationType" => $this->salutationType,
            "domisiliType" => $this->domisiliType,
            "employeeTaxStatusType" => $this->employeeTaxStatusType,
            "employeeWorkStatusType" => $this->employeeWorkStatusType,
            "branch" => $branch['data']['d'] ?? [], // Pastikan ada fallback jika 'd' tidak ada
            "departement" => $departement['data']['d'] ?? [], // Pastikan ada fallback jika 'd' tidak ada
        ]);
    }
    /**
     * @OA\Post(
     * path="/sales-employee",
     * summary="Membuat atau Memperbarui Karyawan",
     * description="Menambahkan karyawan baru atau memperbarui data karyawan yang sudah ada. Jika 'id' disediakan dalam request body, operasi dianggap sebagai update.",
     * operationId="createOrUpdateEmploye",
     * tags={"Karyawan"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data karyawan untuk disimpan atau diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/EmployeInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Karyawan berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/EmployeSaveUpdateDeleteResponse")
     * ),
     * @OA\Response(
     * response=201,
     * description="Karyawan berhasil dibuat.",
     * @OA\JsonContent(ref="#/components/schemas/EmployeSaveUpdateDeleteResponse")
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
        return $this->saveEmploye($request->validated()); // Mengubah nama metode
    }

    /**
     * @OA\Get(
     * path="/sales-employee/{id}",
     * summary="Mendapatkan Detail Karyawan",
     * description="Mengambil detail lengkap satu karyawan berdasarkan ID internalnya.",
     * operationId="getEmployeDetail",
     * tags={"Karyawan"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal karyawan.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail karyawan berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/EmployeData")
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
     * description="Karyawan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Employe not found.")
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
        $response = $this->accurate->get(true, 'employee/detail.do', [], ['id' => $id]);

        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d']);
        }
        return response()->json(['message' => 'Employe not found'], 404);
    }

    /**
     * @OA\Get(
     * path="/sales-employee/{id}/edit",
     * summary="Mendapatkan Detail Karyawan dan Atribut Form Edit",
     * description="Mengambil detail lengkap satu karyawan berdasarkan ID dan memberikan atribut data yang akan digunakan sebagai referensi form input untuk pengeditan.",
     * operationId="getEmployeEditDataAndAttributes",
     * tags={"Karyawan"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal karyawan.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail karyawan dan atribut form berhasil diambil.",
     * @OA\JsonContent(ref="#/components/schemas/EmployeEditResponse")
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
     * description="Karyawan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Employe not found.")
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function edit(string $id)
    {
        try {
            $response = $this->accurate->get(true, 'employee/detail.do', [], ['id' => $id]);

            if (!isset($response['data']['d'])) {
                return response()->json(['message' => 'Employe not found'], 404);
            }

            // Memanggil Acccurate API untuk data atribut form jika diperlukan saat edit
            $branch = $this->accurate->get(true, 'branch/list.do');
            $departement = $this->accurate->get(true, 'department/list.do');


            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [
                    "salutationType" => $this->salutationType,
                    "domisiliType" => $this->domisiliType,
                    "employeeTaxStatusType" => $this->employeeTaxStatusType,
                    "employeeWorkStatusType" => $this->employeeWorkStatusType,
                    "branch" => $branch['data']['d'] ?? [],
                    "departement" => $departement['data']['d'] ?? [],
                ],
            ]);
        } catch (\Throwable $th) {
            \Log::error("Error in EmployeController@edit: " . $th->getMessage(), ['exception' => $th]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/sales-employee/update",
     * summary="Memperbarui Data Karyawan (via POST)",
     * description="Memperbarui data karyawan yang sudah ada. ID karyawan harus disertakan dalam request body.",
     * operationId="updateEmploye",
     * tags={"Karyawan"},
     * security={{"BearerAuth": {}}},
     * @OA\RequestBody(
     * required=true,
     * description="Data karyawan untuk diperbarui, termasuk ID karyawan.",
     * @OA\JsonContent(ref="#/components/schemas/EmployeInput")
     * ),
     * @OA\Response(
     * response=200,
     * description="Karyawan berhasil diperbarui.",
     * @OA\JsonContent(ref="#/components/schemas/EmployeSaveUpdateDeleteResponse")
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
     * description="Karyawan tidak ditemukan (ID tidak valid).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Employe not found or invalid ID.")
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
        return $this->saveEmploye($request->validated());
    }

    /**
     * @OA\Delete(
     * path="/sales-employee/{id}",
     * summary="Menghapus Karyawan",
     * description="Menghapus data karyawan berdasarkan ID internalnya.",
     * operationId="deleteEmploye",
     * tags={"Karyawan"},
     * security={{"BearerAuth": {}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID unik internal karyawan yang akan dihapus.",
     * @OA\Schema(type="string", example="101")
     * ),
     * @OA\Response(
     * response=200,
     * description="Karyawan berhasil dihapus.",
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
     * description="Karyawan tidak ditemukan.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Employe not found or ID not valid for deletion.")
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
        $response = $this->accurate->delete(true, 'employee/delete.do', [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
             return response()->json(['message' => $response['m'] ?? 'Data berhasil dihapus.', 'status' => true], 200);
        }

        return response()->json(['message' => $response['m'] ?? 'Gagal menghapus data karyawan.', 'status' => false], 404);
    }

    /**
     * Save or update employee to Accurate API.
     * @param array $input The validated input data for the employee.
     * @return \Illuminate\Http\JsonResponse
     */
    private function saveEmploye(array $input) // Mengubah nama metode dari saveInvoice
    {
        $response = $this->accurate->post(true, 'employee/save.do', $input, []);

        return response()->json($response);
    }
}
