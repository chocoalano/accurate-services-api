<?php

namespace App\Http\Controllers\Accurate\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Purchase\Invoice\DownRequest;
use App\Http\Requests\Purchase\Invoice\FormRequest;
use App\Http\Requests\Purchase\Invoice\IndexRequest;
use App\Support\Accurate;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;

class InvoiceController extends Controller
{
    protected Accurate $accurate;
    protected array $docType;
    protected array $trxType;
    protected array $taxType;
    protected array $docCode;

    public function __construct(Accurate $accurate)
    {
        $this->accurate = $accurate;

        $this->docCode = ['CTAS_IMPORT', 'CTAS_INVOICE', 'CTAS_PURCHASE', 'CTAS_UNCREDIT', 'DIGUNGGUNG'];
        $this->docType = ['CTAS_IMPORT', 'CTAS_INVOICE', 'CTAS_PURCHASE', 'CTAS_UNCREDIT', 'DIGUNGGUNG'];
        $this->trxType = [
            'CTAS_DOKUMEN_KHUSUS',
            'CTAS_PEMBAYARAN',
            'CTAS_PEMBERITAHUAN_IMPORT',
            'CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN',
            'CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH'
        ];
        $this->taxType = [
            'CTAS_BESARAN_TERTENTU',
            'CTAS_DPP_NILAI_LAIN',
            'CTAS_IMPOR_BARANG_KENA_PAJAK',
            'CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI',
            'CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH',
            'CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH',
            'CTAS_KEPADA_SELAIN_PEMUNGUT_PPN',
            'CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK',
            'CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN',
            'CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN',
            'CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT',
            'CTAS_PENYERAHAN_LAINNYA'
        ];
    }

    /**
     * @OA\Get(
     *   path="/purchase/invoice",
     *   summary="Mendapatkan Daftar Faktur Pembelian",
     *   description="Ambil daftar faktur pembelian Accurate Online (paginasi). Tanggal format dd/MM/yyyy.",
     *   operationId="getPurchaseInvoiceList",
     *   tags={"Purchase: Invoice"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(name="page", in="query", required=true, description="Nomor halaman.", @OA\Schema(type="integer", minimum=1, example=1)),
     *   @OA\Parameter(name="pageSize", in="query", required=true, description="Jumlah item per halaman.", @OA\Schema(type="integer", minimum=1, example=50)),
     *   @OA\Parameter(
     *     name="fields", in="query", required=false,
     *     description="Daftar field dipisah koma (mis. id,name,code,parent)",
     *     @OA\Schema(type="string", example="id,name,code,parent")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       properties={
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(property="status", type="integer", example=200),
     *         @OA\Property(
     *           property="data",
     *           type="object",
     *           properties={
     *             @OA\Property(property="s", type="boolean", example=true),
     *             @OA\Property(
     *               property="d",
     *               type="array",
     *               @OA\Items(
     *                 type="object",
     *                 properties={
     *                   @OA\Property(property="id", type="integer", example=101),
     *                   @OA\Property(property="number", type="string", example="PI-20240626-001"),
     *                   @OA\Property(property="transDate", type="string", example="26/06/2024"),
     *                   @OA\Property(property="vendorName", type="string", example="PT Supplier Maju"),
     *                   @OA\Property(property="currencyCode", type="string", example="IDR"),
     *                   @OA\Property(property="status", type="string", example="OPEN"),
     *                   @OA\Property(property="description", type="string", nullable=true, example="Pembelian bahan baku."),
     *                   @OA\Property(property="subtotal", type="number", format="double", example=500000.0),
     *                   @OA\Property(property="discount", type="number", format="double", example=50000.0),
     *                   @OA\Property(property="tax", type="number", format="double", example=45000.0),
     *                   @OA\Property(property="expenseTotal", type="number", format="double", example=50000.0),
     *                   @OA\Property(property="downPaymentApplied", type="number", format="double", example=100000.0),
     *                   @OA\Property(property="totalAmount", type="number", format="double", example=545000.0),
     *                   @OA\Property(property="amountDue", type="number", format="double", example=445000.0),
     *                   @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama")
     *                 }
     *               )
     *             ),
     *             @OA\Property(
     *               property="sp",
     *               type="object",
     *               properties={
     *                 @OA\Property(property="page", type="integer", example=1),
     *                 @OA\Property(property="pageSize", type="integer", example=50),
     *                 @OA\Property(property="pageCount", type="integer", example=1),
     *                 @OA\Property(property="rowCount", type="integer", example=5),
     *                 @OA\Property(property="start", type="integer", example=0)
     *               }
     *             )
     *           }
     *         )
     *       }
     *     )
     *   ),
     *   @OA\Response(
     *     response=401,
     *     description="Tidak terautentikasi.",
     *     @OA\JsonContent(type="object", properties={
     *       @OA\Property(property="s", type="boolean", example=false),
     *       @OA\Property(property="m", type="string", example="Unauthenticated."),
     *       @OA\Property(property="d", type="object", nullable=true)
     *     })
     *   ),
     *   @OA\Response(
     *     response=500,
     *     description="Kesalahan internal server.",
     *     @OA\JsonContent(type="object", properties={
     *       @OA\Property(property="s", type="boolean", example=false),
     *       @OA\Property(property="m", type="string", example="Internal Server Error"),
     *       @OA\Property(property="d", type="object", nullable=true)
     *     })
     *   )
     * )
     */
    public function index(IndexRequest $request)
{
    $validated = $request->validated();
    $url = 'purchase-invoice/list.do';
    $query = [
        'sp.page' => $validated['page'],
        'sp.pageSize' => $validated['pageSize'],
    ];

    // Check if the 'fields' key exists in the validated data
    if (isset($validated['fields'])) {
        $query['fields'] = $validated['fields'];
    }

    $response = $this->accurate->get(true, $url, [], $query);

    return response()->json($response);
}

    /**
     * @OA\Get(
     *   path="/purchase/invoice/create",
     *   summary="Atribut Form Pembuatan Faktur Pembelian",
     *   description="Daftar opsi enum untuk form create faktur.",
     *   operationId="getPurchaseInvoiceCreateFormAttributes",
     *   tags={"Purchase: Invoice"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       properties={
     *         @OA\Property(property="doc_type", type="array", @OA\Items(type="string", enum={"CTAS_IMPORT","CTAS_INVOICE","CTAS_PURCHASE","CTAS_UNCREDIT","DIGUNGGUNG"})),
     *         @OA\Property(property="trx_type", type="array", @OA\Items(type="string", enum={"CTAS_DOKUMEN_KHUSUS","CTAS_PEMBAYARAN","CTAS_PEMBERITAHUAN_IMPORT","CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN","CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH"})),
     *         @OA\Property(property="tax_type", type="array", @OA\Items(type="string", enum={
     *           "CTAS_BESARAN_TERTENTU","CTAS_DPP_NILAI_LAIN","CTAS_IMPOR_BARANG_KENA_PAJAK",
     *           "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI",
     *           "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH",
     *           "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH",
     *           "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
     *           "CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK",
     *           "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN",
     *           "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN",
     *           "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT",
     *           "CTAS_PENYERAHAN_LAINNYA"
     *         }))
     *       }
     *     )
     *   )
     * )
     */
    public function create()
    {
        return response()->json([
            'doc_type' => $this->docType,
            'trx_type' => $this->trxType,
            'tax_type' => $this->taxType,
        ]);
    }

    /**
     * @OA\Get(
     *   path="/purchase/invoice/downpay/create",
     *   summary="Atribut Form Uang Muka Pembelian",
     *   description="Daftar opsi enum untuk form pembuatan DP.",
     *   operationId="getPurchaseInvoiceDownPaymentFormAttributes",
     *   tags={"Purchase: Invoice"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       properties={
     *         @OA\Property(property="doc_code", type="array", @OA\Items(type="string", enum={"CTAS_IMPORT","CTAS_INVOICE","CTAS_PURCHASE","CTAS_UNCREDIT","DIGUNGGUNG"})),
     *         @OA\Property(property="trx_type", type="array", @OA\Items(type="string", enum={"CTAS_DOKUMEN_KHUSUS","CTAS_PEMBAYARAN","CTAS_PEMBERITAHUAN_IMPORT","CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN","CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH"})),
     *         @OA\Property(property="tax_type", type="array", @OA\Items(type="string", enum={
     *           "CTAS_BESARAN_TERTENTU","CTAS_DPP_NILAI_LAIN","CTAS_IMPOR_BARANG_KENA_PAJAK",
     *           "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI",
     *           "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH",
     *           "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH",
     *           "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
     *           "CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK",
     *           "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN",
     *           "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN",
     *           "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT",
     *           "CTAS_PENYERAHAN_LAINNYA"
     *         }))
     *       }
     *     )
     *   )
     * )
     */
    public function downpayForm()
    {
        return response()->json([
            'doc_code' => $this->docCode,
            'trx_type' => $this->trxType,
            'tax_type' => $this->taxType,
        ]);
    }

    /**
     * @OA\Post(
     *   path="/purchase/invoice",
     *   summary="Create/Update Faktur Pembelian (save.do)",
     *   description="Jika body memuat 'id' maka update, jika tidak create. Tanggal dd/MM/yyyy.",
     *   operationId="createOrUpdatePurchaseInvoice",
     *   tags={"Purchase: Invoice"},
     *   security={{"BearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"vendorNo","transDate"},
     *       properties={
     *         @OA\Property(property="id", type="integer", nullable=true, example=101),
     *         @OA\Property(property="vendorNo", type="string", example="VEN-00023"),
     *         @OA\Property(property="transDate", type="string", pattern="^\\d{2}/\\d{2}/\\d{4}$", example="31/03/2024"),
     *         @OA\Property(property="billNumber", type="string", nullable=true, example="IVC-9981"),
     *         @OA\Property(property="number", type="string", nullable=true, example="PI-20240626-001"),
     *         @OA\Property(property="description", type="string", nullable=true, example="Pembelian bahan baku bulan Juni."),
     *         @OA\Property(property="branchId", type="integer", nullable=true, example=1),
     *         @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama"),
     *         @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR"),
     *         @OA\Property(property="rate", type="number", format="double", nullable=true, example=1.0),
     *         @OA\Property(property="fiscalRate", type="number", format="double", nullable=true, example=1.0),
     *         @OA\Property(property="inclusiveTax", type="boolean", nullable=true, example=false),
     *         @OA\Property(property="taxable", type="boolean", nullable=true, example=true),
     *         @OA\Property(property="tax1Name", type="string", nullable=true, example="PPN"),
     *         @OA\Property(property="taxDate", type="string", nullable=true, pattern="^\\d{2}/\\d{2}/\\d{4}$", example="26/06/2024"),
     *         @OA\Property(property="taxNumber", type="string", nullable=true, example="010.001.24.12345678"),
     *         @OA\Property(property="cashDiscPercent", type="number", format="double", nullable=true, example=1.5),
     *         @OA\Property(property="cashDiscount", type="number", format="double", nullable=true, example=5000.00),
     *         @OA\Property(property="paymentTermName", type="string", nullable=true, example="Net 30"),
     *         @OA\Property(property="reverseInvoice", type="boolean", nullable=true, example=false),
     *         @OA\Property(property="invoiceDp", type="boolean", nullable=true, example=false),
     *         @OA\Property(property="inputDownPayment", type="number", format="double", nullable=true, example=0.0),
     *         @OA\Property(property="orderDownPaymentNumber", type="string", nullable=true, example="DP-PO-0005"),
     *         @OA\Property(property="fobName", type="string", nullable=true, example="Pabrik Vendor"),
     *         @OA\Property(property="shipmentName", type="string", nullable=true, example="JNE Trucking"),
     *         @OA\Property(property="shipDate", type="string", nullable=true, pattern="^\\d{2}/\\d{2}/\\d{4}$", example="26/06/2024"),
     *         @OA\Property(property="toAddress", type="string", nullable=true, example="Jl. Industri No. 1, Bandung"),
     *         @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1),
     *         @OA\Property(property="fillPriceByVendorPrice", type="boolean", nullable=true, example=true),
     *         @OA\Property(property="documentCode", type="string", nullable=true, enum={"CTAS_IMPORT","CTAS_INVOICE","CTAS_PURCHASE","CTAS_UNCREDIT","DIGUNGGUNG"}, example="CTAS_INVOICE"),
     *         @OA\Property(property="documentTransaction", type="string", nullable=true, enum={"CTAS_DOKUMEN_KHUSUS","CTAS_PEMBAYARAN","CTAS_PEMBERITAHUAN_IMPORT","CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN","CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH"}, example="CTAS_PEMBAYARAN"),
     *         @OA\Property(property="vendorTaxType", type="string", nullable=true, enum={
     *           "CTAS_BESARAN_TERTENTU","CTAS_DPP_NILAI_LAIN","CTAS_IMPOR_BARANG_KENA_PAJAK",
     *           "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI",
     *           "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH",
     *           "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH",
     *           "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
     *           "CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK",
     *           "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN",
     *           "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN",
     *           "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT",
     *           "CTAS_PENYERAHAN_LAINNYA"
     *         }, example="CTAS_KEPADA_SELAIN_PEMUNGUT_PPN"),
     *         @OA\Property(
     *           property="detailItem",
     *           type="array",
     *           @OA\Items(
     *             type="object",
     *             required={"itemNo","quantity","unitPrice"},
     *             properties={
     *               @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true),
     *               @OA\Property(property="id", type="integer", nullable=true, example=101),
     *               @OA\Property(property="itemNo", type="string", example="RAW-001"),
     *               @OA\Property(property="detailName", type="string", nullable=true, example="Bubuk Matcha Premium"),
     *               @OA\Property(property="detailNotes", type="string", nullable=true, example="Batch 2406, exp 06/2026"),
     *               @OA\Property(property="quantity", type="number", format="double", example=5.0),
     *               @OA\Property(property="itemUnitName", type="string", nullable=true, example="Sak"),
     *               @OA\Property(property="unitPrice", type="number", format="double", example=100000.00),
     *               @OA\Property(property="itemDiscPercent", type="number", format="double", nullable=true, example=10.0),
     *               @OA\Property(property="itemCashDiscount", type="number", format="double", nullable=true, example=0.0),
     *               @OA\Property(property="useTax1", type="boolean", nullable=true, example=true),
     *               @OA\Property(property="useTax2", type="boolean", nullable=true, example=false),
     *               @OA\Property(property="useTax3", type="boolean", nullable=true, example=false),
     *               @OA\Property(property="warehouseName", type="string", nullable=true, example="Gudang A"),
     *               @OA\Property(property="departmentName", type="string", nullable=true, example="Logistik"),
     *               @OA\Property(property="projectNo", type="string", nullable=true, example="PROJ-001"),
     *               @OA\Property(property="purchaseOrderNumber", type="string", nullable=true, example="PO-00045"),
     *               @OA\Property(property="purchaseRequisitionNumber", type="string", nullable=true, example="PR-00011"),
     *               @OA\Property(property="receiveItemNumber", type="string", nullable=true, example="RI-00022"),
     *               @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Kategori A"),
     *               @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null)
     *             }
     *           )
     *         ),
     *         @OA\Property(
     *           property="detailExpense",
     *           type="array",
     *           @OA\Items(
     *             type="object",
     *             properties={
     *               @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true),
     *               @OA\Property(property="id", type="integer", nullable=true, example=7),
     *               @OA\Property(property="expenseName", type="string", nullable=true, example="Biaya Pengiriman"),
     *               @OA\Property(property="expenseAmount", type="number", format="double", example=50000.00),
     *               @OA\Property(property="amountCurrency", type="number", format="double", nullable=true, example=50000.00),
     *               @OA\Property(property="expenseCurrencyCode", type="string", nullable=true, example="IDR"),
     *               @OA\Property(property="accountNo", type="string", nullable=true, example="5101-01"),
     *               @OA\Property(property="allocateToItemCost", type="boolean", nullable=true, example=true),
     *               @OA\Property(property="chargedVendorName", type="string", nullable=true, example="Vendor Ekspedisi A"),
     *               @OA\Property(property="departmentName", type="string", nullable=true, example="Pembelian"),
     *               @OA\Property(property="purchaseOrderNumber", type="string", nullable=true, example="PO-00045"),
     *               @OA\Property(property="expenseNotes", type="string", nullable=true, example="Pengiriman darat, 2 hari"),
     *               @OA\Property(property="dataClassification1Name", type="string", nullable=true, example="Proyek X"),
     *               @OA\Property(property="dataClassification2Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification3Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification4Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification5Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification6Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification7Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification8Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification9Name", type="string", nullable=true, example=null),
     *               @OA\Property(property="dataClassification10Name", type="string", nullable=true, example=null)
     *             }
     *           )
     *         ),
     *         @OA\Property(
     *           property="detailDownPayment",
     *           type="array",
     *           @OA\Items(
     *             type="object",
     *             properties={
     *               @OA\Property(property="id", type="integer", nullable=true, example=12),
     *               @OA\Property(property="invoiceNumber", type="string", nullable=true, example="DP-PI-00012"),
     *               @OA\Property(property="paymentAmount", type="number", format="double", example=250000.00),
     *               @OA\Property(property="_status", type="string", enum={"delete"}, nullable=true)
     *             }
     *           )
     *         )
     *       }
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Sukses (create/update).",
     *     @OA\JsonContent(type="object", properties={
     *       @OA\Property(property="s", type="boolean", example=true),
     *       @OA\Property(property="m", type="string", example="Data berhasil disimpan."),
     *       @OA\Property(property="d", type="integer", nullable=true, example=101)
     *     })
     *   ),
     *   @OA\Response(response=401, description="Tidak terautentikasi.", @OA\JsonContent(type="object", properties={
     *     @OA\Property(property="s", type="boolean", example=false),
     *     @OA\Property(property="m", type="string", example="Unauthenticated."),
     *     @OA\Property(property="d", type="object", nullable=true)
     *   })),
     *   @OA\Response(response=422, description="Validasi gagal.", @OA\JsonContent(type="object", properties={
     *     @OA\Property(property="s", type="boolean", example=false),
     *     @OA\Property(property="m", type="string", example="Validation failed"),
     *     @OA\Property(property="d", type="object", example={"vendorNo":{"The vendor no field is required."}})
     *   })),
     *   @OA\Response(response=500, description="Kesalahan internal server.", @OA\JsonContent(type="object", properties={
     *     @OA\Property(property="s", type="boolean", example=false),
     *     @OA\Property(property="m", type="string", example="Internal Server Error"),
     *     @OA\Property(property="d", type="object", nullable=true)
     *   }))
     * )
     */
    public function store(FormRequest $request)
    {
        $input = $request->validated();
        $url = 'purchase-invoice/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, $response['status']);
    }

    /**
     * @OA\Post(
     *   path="/purchase/invoice/downpay",
     *   summary="Membuat Uang Muka Faktur Pembelian",
     *   description="Membuat DP pembelian. Tanggal dd/MM/yyyy.",
     *   operationId="createPurchaseInvoiceDownPayment",
     *   tags={"Purchase: Invoice"},
     *   security={{"BearerAuth": {}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       type="object",
     *       required={"billNumber","dpAmount","vendorNo"},
     *       properties={
     *         @OA\Property(property="billNumber", type="string", example="BILL-DP-001"),
     *         @OA\Property(property="dpAmount", type="number", format="double", example=100000.00),
     *         @OA\Property(property="vendorNo", type="string", example="VEN-00023"),
     *         @OA\Property(property="number", type="string", nullable=true, example="DP-PI-20240626-001"),
     *         @OA\Property(property="description", type="string", nullable=true, example="Uang muka pembelian Juni."),
     *         @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR"),
     *         @OA\Property(property="rate", type="number", format="double", nullable=true, example=1.0),
     *         @OA\Property(property="fiscalRate", type="number", format="double", nullable=true, example=1.0),
     *         @OA\Property(property="inclusiveTax", type="boolean", nullable=true, example=false),
     *         @OA\Property(property="isTaxable", type="boolean", nullable=true, example=true),
     *         @OA\Property(property="tax1Name", type="string", nullable=true, example="PPN"),
     *         @OA\Property(property="taxDate", type="string", nullable=true, pattern="^\\d{2}/\\d{2}/\\d{4}$", example="26/06/2024"),
     *         @OA\Property(property="taxNumber", type="string", nullable=true, example="010.001.24.98765432"),
     *         @OA\Property(property="paymentTermName", type="string", nullable=true, example="Net 30"),
     *         @OA\Property(property="poNumber", type="string", nullable=true, example="PO-00045"),
     *         @OA\Property(property="toAddress", type="string", nullable=true, example="Jl. Penerima DP No. 2"),
     *         @OA\Property(property="transDate", type="string", nullable=true, pattern="^\\d{2}/\\d{2}/\\d{4}$", example="26/06/2024"),
     *         @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=1),
     *         @OA\Property(property="documentCode", type="string", nullable=true, enum={"CTAS_IMPORT","CTAS_INVOICE","CTAS_PURCHASE","CTAS_UNCREDIT","DIGUNGGUNG"}, example="CTAS_INVOICE"),
     *         @OA\Property(property="documentTransaction", type="string", nullable=true, enum={"CTAS_DOKUMEN_KHUSUS","CTAS_PEMBAYARAN","CTAS_PEMBERITAHUAN_IMPORT","CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN","CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH"}, example="CTAS_PEMBAYARAN"),
     *         @OA\Property(property="vendorTaxType", type="string", nullable=true, enum={
     *           "CTAS_BESARAN_TERTENTU","CTAS_DPP_NILAI_LAIN","CTAS_IMPOR_BARANG_KENA_PAJAK",
     *           "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR NEGERI",
     *           "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH",
     *           "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH",
     *           "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
     *           "CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK",
     *           "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN",
     *           "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN",
     *           "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT",
     *           "CTAS_PENYERAHAN_LAINNYA"
     *         }, example="CTAS_KEPADA_SELAIN_PEMUNGUT_PPN")
     *       }
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Sukses.",
     *     @OA\JsonContent(type="object", properties={
     *       @OA\Property(property="s", type="boolean", example=true),
     *       @OA\Property(property="m", type="string", example="Data berhasil disimpan."),
     *       @OA\Property(property="d", type="integer", nullable=true, example=555)
     *     })
     *   )
     * )
     */
    public function downpay(DownRequest $request)
    {
        $input = $request->validated();
        $url = 'purchase-invoice/create-down-payment.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, 200);
    }

    /**
     * @OA\Get(
     *   path="/purchase/invoice/{id}",
     *   summary="Detail Faktur Pembelian",
     *   description="Detail faktur pembelian berdasarkan ID internal Accurate.",
     *   operationId="getPurchaseInvoiceDetail",
     *   tags={"Purchase: Invoice"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(name="id", in="path", required=true, description="ID internal Accurate.", @OA\Schema(type="string", example="101")),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       properties={
     *         @OA\Property(property="id", type="integer", example=101),
     *         @OA\Property(property="number", type="string", example="PI-20240626-001"),
     *         @OA\Property(property="transDate", type="string", example="26/06/2024"),
     *         @OA\Property(property="vendorName", type="string", example="PT Supplier Maju"),
     *         @OA\Property(property="currencyCode", type="string", example="IDR"),
     *         @OA\Property(property="status", type="string", example="OPEN"),
     *         @OA\Property(property="description", type="string", nullable=true, example="Pembelian bahan baku."),
     *         @OA\Property(property="subtotal", type="number", format="double", example=500000.0),
     *         @OA\Property(property="discount", type="number", format="double", example=50000.0),
     *         @OA\Property(property="tax", type="number", format="double", example=45000.0),
     *         @OA\Property(property="expenseTotal", type="number", format="double", example=50000.0),
     *         @OA\Property(property="downPaymentApplied", type="number", format="double", example=100000.0),
     *         @OA\Property(property="totalAmount", type="number", format="double", example=545000.0),
     *         @OA\Property(property="amountDue", type="number", format="double", example=445000.0),
     *         @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Utama"),
     *         @OA\Property(
     *           property="detailItem",
     *           type="array",
     *           @OA\Items(type="object")
     *         ),
     *         @OA\Property(
     *           property="detailExpense",
     *           type="array",
     *           @OA\Items(type="object")
     *         ),
     *         @OA\Property(
     *           property="detailDownPayment",
     *           type="array",
     *           @OA\Items(type="object")
     *         )
     *       }
     *     )
     *   ),
     *   @OA\Response(response=404, description="Tidak ditemukan.", @OA\JsonContent(type="object", properties={
     *     @OA\Property(property="s", type="boolean", example=false),
     *     @OA\Property(property="m", type="string", example="Purchase Invoice not found."),
     *     @OA\Property(property="d", type="object", nullable=true)
     *   }))
     * )
     */
    public function show(string $id)
    {
        $url = 'purchase-invoice/detail.do';
        $response = $this->accurate->get(true, $url, [], ['id' => $id]);

        if (isset($response['data']['d'])) {
            return response()->json($response['data']['d'], 200);
        }
        return response()->json(['s' => false, 'm' => 'Purchase Invoice not found.', 'd' => null], 404);
    }

    /**
     * @OA\Get(
     *   path="/purchase/invoice/{id}/edit",
     *   summary="Detail Faktur + Atribut Form Edit",
     *   description="Kombinasi detail faktur & opsi form edit.",
     *   operationId="getPurchaseInvoiceEditDataAndAttributes",
     *   tags={"Purchase: Invoice"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(name="id", in="path", required=true, description="ID internal Accurate.", @OA\Schema(type="string", example="101")),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       properties={
     *         @OA\Property(
     *           property="data_edit",
     *           type="object",
     *           properties={
     *             @OA\Property(property="id", type="integer", example=101),
     *             @OA\Property(property="number", type="string", example="PI-20240626-001")
     *           }
     *         ),
     *         @OA\Property(
     *           property="form_attribute",
     *           type="object",
     *           properties={
     *             @OA\Property(property="doc_type", type="array", @OA\Items(type="string", enum={"CTAS_IMPORT","CTAS_INVOICE","CTAS_PURCHASE","CTAS_UNCREDIT","DIGUNGGUNG"})),
     *             @OA\Property(property="trx_type", type="array", @OA\Items(type="string", enum={"CTAS_DOKUMEN_KHUSUS","CTAS_PEMBAYARAN","CTAS_PEMBERITAHUAN_IMPORT","CTAS_PEMBERITAHUAN_IMPORT_DAN_PEMBAYARAN","CTAS_SURAT_KETETAPAN_PAJAK_KURANG_TAMBAH"})),
     *             @OA\Property(property="tax_type", type="array", @OA\Items(type="string", enum={
     *               "CTAS_BESARAN_TERTENTU","CTAS_DPP_NILAI_LAIN","CTAS_IMPOR_BARANG_KENA_PAJAK",
     *               "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI",
     *               "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH",
     *               "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH",
     *               "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
     *               "CTAS_PEMANFAATAN_BARANG_TIDAK_BERWUJUD_DAN_JASA_KENA_PAJAK",
     *               "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN",
     *               "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN",
     *               "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT",
     *               "CTAS_PENYERAHAN_LAINNYA"
     *             }))
     *           }
     *         )
     *       }
     *     )
     *   )
     * )
     */
    public function edit(string $id)
    {
        try {
            $url = 'purchase-invoice/detail.do';
            $response = $this->accurate->get(true, $url, [], ['id' => $id]);

            if (!isset($response['data']['d'])) {
                return response()->json(['s' => false, 'm' => 'Purchase Invoice not found.', 'd' => null], 404);
            }

            return response()->json([
                'data_edit' => $response['data']['d'],
                'form_attribute' => [
                    'doc_type' => $this->docType,
                    'trx_type' => $this->trxType,
                    'tax_type' => $this->taxType,
                ]
            ], 200);
        } catch (\Throwable $th) {
            Log::error("Error in Purchase\\InvoiceController@edit: {$th->getMessage()}", ['exception' => $th]);
            return response()->json(['s' => false, 'm' => 'Internal Server Error', 'd' => null], 500);
        }
    }

    /**
     * @OA\Put(
     *   path="/purchase/invoice",
     *   summary="Update Faktur Pembelian (PUT → save.do)",
     *   description="Update faktur; body harus memuat 'id'.",
     *   operationId="updatePurchaseInvoice",
     *   tags={"Purchase: Invoice"},
     *   security={{"BearerAuth": {}}},
     *   @OA\RequestBody(required=true, @OA\JsonContent(type="object", properties={
     *     @OA\Property(property="id", type="integer", example=101)
     *   })),
     *   @OA\Response(response=200, description="Sukses.", @OA\JsonContent(type="object", properties={
     *     @OA\Property(property="s", type="boolean", example=true),
     *     @OA\Property(property="m", type="string", example="Data berhasil disimpan."),
     *     @OA\Property(property="d", type="integer", nullable=true, example=101)
     *   }))
     * )
     */
    public function update(FormRequest $request)
    {
        $input = $request->validated();
        $url = 'purchase-invoice/save.do';
        $response = $this->accurate->post(true, $url, $input, []);
        return response()->json($response, $response['status']);
    }

    /**
     * @OA\Delete(
     *   path="/purchase/invoice/{id}",
     *   summary="Menghapus Faktur Pembelian",
     *   description="Hapus faktur berdasarkan ID internal Accurate.",
     *   operationId="deletePurchaseInvoice",
     *   tags={"Purchase: Invoice"},
     *   security={{"BearerAuth": {}}},
     *   @OA\Parameter(name="id", in="path", required=true, description="ID internal Accurate.", @OA\Schema(type="string", example="101")),
     *   @OA\Response(response=200, description="Sukses.", @OA\JsonContent(type="object", properties={
     *     @OA\Property(property="s", type="boolean", example=true),
     *     @OA\Property(property="m", type="string", example="Data berhasil dihapus."),
     *     @OA\Property(property="d", type="integer", nullable=true, example=101)
     *   })),
     *   @OA\Response(response=404, description="Tidak ditemukan.", @OA\JsonContent(type="object", properties={
     *     @OA\Property(property="s", type="boolean", example=false),
     *     @OA\Property(property="m", type="string", example="Purchase Invoice not found or ID not valid for deletion."),
     *     @OA\Property(property="d", type="object", nullable=true)
     *   }))
     * )
     */
    public function destroy(string $id)
    {
        $url = 'purchase-invoice/delete.do';
        $response = $this->accurate->delete(true, $url, [$id], []);

        if (isset($response['s']) && $response['s'] === true) {
            return response()->json($response, 200);
        }
        return response()->json([
            's' => false,
            'm' => $response['m'] ?? 'Purchase Invoice not found or ID not valid for deletion.',
            'd' => null
        ], 404);
    }
}
