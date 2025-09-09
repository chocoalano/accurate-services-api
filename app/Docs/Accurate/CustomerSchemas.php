<?php

namespace App\Docs\Accurate;

/**
 * --- NESTED SCHEMAS (REFERENCED BY CustomerData & CustomerInput) ---
 *
 * @OA\Schema(
 * schema="DetailContactItem",
 * title="Detail Kontak Pelanggan",
 * description="Item detail kontak dalam daftar detailContact.",
 * type="object",
 * properties={
 * @OA\Property(property="bbmPin", type="string", nullable=true, example="1234", description="PIN BBM (opsional, mungkin merujuk ke WhatsApp/lainnya)."),
 * @OA\Property(property="email", type="string", format="email", nullable=true, example="contact@example.com", description="Email kontak."),
 * @OA\Property(property="fax", type="string", nullable=true, example="021-1234567", description="Nomor Fax kontak."),
 * @OA\Property(property="homePhone", type="string", nullable=true, example="021-7654321", description="Nomor telepon rumah kontak."),
 * @OA\Property(property="mobilePhone", type="string", nullable=true, example="081234567890", description="Nomor telepon seluler kontak."),
 * @OA\Property(property="name", type="string", example="John Doe", description="Nama kontak."),
 * @OA\Property(property="notes", type="string", nullable=true, example="Kontak utama", description="Catatan tentang kontak."),
 * @OA\Property(property="position", type="string", nullable=true, example="Manager", description="Jabatan kontak."),
 * @OA\Property(property="salutation", type="string", enum={"MR", "MRS", "MS", "DR", "PROF"}, example="MR", description="Sapaan kontak."),
 * @OA\Property(property="website", type="string", format="url", nullable=true, example="http://example.com", description="Situs web kontak."),
 * @OA\Property(property="workPhone", type="string", nullable=true, example="021-1234567", description="Nomor telepon kantor kontak.")
 * },
 * required={"name"}
 * )
 *
 * @OA\Schema(
 * schema="DetailOpenBalanceItem",
 * title="Detail Saldo Awal Pelanggan",
 * description="Item detail saldo awal dalam daftar detailOpenBalance.",
 * type="object",
 * properties={
 * @OA\Property(property="amount", type="number", format="double", example=5000000.00, description="Jumlah saldo awal."),
 * @OA\Property(property="asOf", type="string", example="31/03/2016", description="Tanggal per (DD/MM/YYYY)."),
 * @OA\Property(property="currencyCode", type="string", example="IDR", description="Kode mata uang."),
 * @OA\Property(property="description", type="string", nullable=true, example="Saldo awal pelanggan", description="Deskripsi saldo awal."),
 * @OA\Property(property="number", type="string", nullable=true, example="OB-001", description="Nomor dokumen saldo awal."),
 * @OA\Property(property="paymentTermName", type="string", nullable=true, example="Net 30", description="Nama syarat pembayaran."),
 * @OA\Property(property="rate", type="number", format="double", example=1, description="Kurs mata uang."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=2, description="Tipe nomor otomatis.")
 * },
 * required={"amount", "asOf", "currencyCode"}
 * )
 *
 * @OA\Schema(
 * schema="DetailShipAddressItem",
 * title="Detail Alamat Pengiriman",
 * description="Item detail alamat pengiriman dalam daftar detailShipAddress.",
 * type="object",
 * properties={
 * @OA\Property(property="city", type="string", nullable=true, example="Bandung", description="Kota alamat pengiriman."),
 * @OA\Property(property="country", type="string", nullable=true, example="Indonesia", description="Negara alamat pengiriman."),
 * @OA\Property(property="province", type="string", nullable=true, example="Jawa Barat", description="Provinsi alamat pengiriman."),
 * @OA\Property(property="street", type="string", nullable=true, example="Jl. Asia Afrika No.15", description="Jalan alamat pengiriman."),
 * @OA\Property(property="zipCode", type="string", nullable=true, example="40111", description="Kode pos alamat pengiriman.")
 * }
 * )
 *
 * @OA\Schema(
 * schema="CustomerPriceCategory",
 * title="Kategori Harga Pelanggan",
 * type="object",
 * properties={
 * @OA\Property(property="defaultCategory", type="boolean", example=true),
 * @OA\Property(property="optLock", type="integer", example=0),
 * @OA\Property(property="name", type="string", example="Umum"),
 * @OA\Property(property="description", type="string", nullable=true, example=null),
 * @OA\Property(property="id", type="integer", example=50)
 * },
 * required={"defaultCategory", "optLock", "name", "id"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerDiscountCategory",
 * title="Kategori Diskon Pelanggan",
 * type="object",
 * properties={
 * @OA\Property(property="defaultCategory", type="boolean", example=true),
 * @OA\Property(property="optLock", type="integer", example=0),
 * @OA\Property(property="name", type="string", example="Umum"),
 * @OA\Property(property="description", type="string", nullable=true, example=null),
 * @OA\Property(property="id", type="integer", example=50)
 * },
 * required={"defaultCategory", "optLock", "name", "id"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerCurrency",
 * title="Mata Uang Pelanggan",
 * type="object",
 * properties={
 * @OA\Property(property="defaultArAccountId", type="integer", example=57),
 * @OA\Property(property="symbol", type="string", example="Rp"),
 * @OA\Property(property="code", type="string", example="IDR"),
 * @OA\Property(property="defaultSalesDiscAccountId", type="integer", example=60),
 * @OA\Property(property="optLock", type="integer", example=7),
 * @OA\Property(property="currencyConverterType", type="string", example="TO_LOCAL"),
 * @OA\Property(property="defaultAdvSalesAccountId", type="integer", example=59),
 * @OA\Property(property="exchangeRateSymbolCode", type="string", example="IDR"),
 * @OA\Property(property="defaultAdvPurchaseAccountId", type="integer", example=58),
 * @OA\Property(property="defaultRealizeGlAccountId", type="integer", example=61),
 * @OA\Property(property="name", type="string", example="Indonesian Rupiah"),
 * @OA\Property(property="codeSymbol", type="string", example="IDR Rp"),
 * @OA\Property(property="id", type="integer", example=50),
 * @OA\Property(property="defaultApAccountId", type="integer", example=56),
 * @OA\Property(property="defaultUnrealizeGlAccountId", type="integer", example=62),
 * @OA\Property(property="converterTypeName", type="string", example="1 IDR=XXX IDR")
 * },
 * required={"defaultArAccountId", "symbol", "code", "defaultSalesDiscAccountId", "optLock", "currencyConverterType", "defaultAdvSalesAccountId", "exchangeRateSymbolCode", "defaultAdvPurchaseAccountId", "defaultRealizeGlAccountId", "name", "codeSymbol", "id", "defaultApAccountId", "defaultUnrealizeGlAccountId", "converterTypeName"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerTerm",
 * title="Syarat Pembayaran Pelanggan",
 * type="object",
 * properties={
 * @OA\Property(property="cashOnDelivery", type="boolean", example=true),
 * @OA\Property(property="optLock", type="integer", example=0),
 * @OA\Property(property="installmentTerm", type="boolean", example=false),
 * @OA\Property(property="discDays", type="integer", example=0),
 * @OA\Property(property="name", type="string", example="C.O.D"),
 * @OA\Property(property="defaultTerm", type="boolean", example=true),
 * @OA\Property(property="memo", type="string", nullable=true, example=null),
 * @OA\Property(property="discPC", type="integer", example=0),
 * @OA\Property(property="id", type="integer", example=100),
 * @OA\Property(property="netDays", type="integer", example=0),
 * @OA\Property(property="suspended", type="boolean", example=false),
 * @OA\Property(property="manualTerm", type="boolean", example=false)
 * },
 * required={"cashOnDelivery", "optLock", "installmentTerm", "discDays", "name", "defaultTerm", "discPC", "id", "netDays", "suspended", "manualTerm"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerCategoryParent",
 * title="Parent Kategori Pelanggan",
 * type="object",
 * properties={
 * @OA\Property(property="sub", type="boolean", example=false),
 * @OA\Property(property="parent", type="string", nullable=true, example=null),
 * @OA\Property(property="lvl", type="integer", example=0),
 * @OA\Property(property="defaultCategory", type="boolean", example=false),
 * @OA\Property(property="nameWithIndentStrip", type="string", example="Root"),
 * @OA\Property(property="optLock", type="integer", example=0),
 * @OA\Property(property="name", type="string", example="Root"),
 * @OA\Property(property="parentNode", type="boolean", example=true),
 * @OA\Property(property="nameWithIndent", type="string", example="Root"),
 * @OA\Property(property="id", type="integer", example=50)
 * },
 * required={"sub", "lvl", "defaultCategory", "nameWithIndentStrip", "optLock", "name", "parentNode", "nameWithIndent", "id"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerCategory",
 * title="Kategori Pelanggan",
 * type="object",
 * properties={
 * @OA\Property(property="sub", type="boolean", example=false),
 * @OA\Property(property="parent", ref="#/components/schemas/CustomerCategoryParent", description="Parent kategori."),
 * @OA\Property(property="lvl", type="integer", example=1),
 * @OA\Property(property="defaultCategory", type="boolean", example=true),
 * @OA\Property(property="nameWithIndentStrip", type="string", example="Umum"),
 * @OA\Property(property="optLock", type="integer", example=0),
 * @OA\Property(property="name", type="string", example="Umum"),
 * @OA\Property(property="parentNode", type="boolean", example=false),
 * @OA\Property(property="nameWithIndent", type="string", example="Umum"),
 * @OA\Property(property="id", type="integer", example=51)
 * },
 * required={"sub", "parent", "lvl", "defaultCategory", "nameWithIndentStrip", "optLock", "name", "parentNode", "nameWithIndent", "id"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerBalanceItem",
 * title="Item Saldo Pelanggan",
 * type="object",
 * properties={
 * @OA\Property(property="balanceCode", type="string", example="IDR Rp"),
 * @OA\Property(property="balance", type="number", format="double", example=0)
 * },
 * required={"balanceCode", "balance"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerSalesmanItem",
 * title="Item Salesman Pelanggan",
 * description="Asumsi ini adalah skema untuk item dalam salesmanList, meskipun JSON Anda hanya memiliki list nomor.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="Salesman One")
 * }
 * )
 *
 * @OA\Schema(
 * schema="CustomerDownPaymentAccountItem",
 * title="Item Akun Uang Muka Pelanggan",
 * description="Asumsi ini adalah skema untuk item dalam customerDownPaymentAccountList, meskipun JSON Anda hanya memiliki list nomor.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="number", type="string", example="DP-001"),
 * @OA\Property(property="name", type="string", example="Uang Muka Penjualan")
 * }
 * )
 *
 * @OA\Schema(
 * schema="CustomerReceivableAccountItem",
 * title="Item Akun Piutang Pelanggan",
 * description="Asumsi ini adalah skema untuk item dalam customerReceivableAccountList, meskipun JSON Anda hanya memiliki list nomor.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="number", type="string", example="AR-001"),
 * @OA\Property(property="name", type="string", example="Piutang Usaha")
 * }
 * )
 *
 * @OA\Schema(
 * schema="CustomerDetailResellerUserItem",
 * title="Item Detail Reseller User",
 * description="Asumsi skema untuk item dalam detailResellerUser.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="username", type="string", example="reseller1")
 * }
 * )
 *
 * @OA\Schema(
 * schema="CustomerStoreCategoryItem",
 * title="Item Kategori Toko Pelanggan",
 * description="Asumsi skema untuk item dalam storeCategoryList.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="Toko Online")
 * }
 * )
 *
 * @OA\Schema(
 * schema="CustomerShippingAreaDetailItem",
 * title="Item Detail Area Pengiriman Pelanggan",
 * description="Asumsi skema untuk item dalam shippingAreaDetailList.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", example=1),
 * @OA\Property(property="areaName", type="string", example="Jakarta Barat")
 * }
 * )
 *
 * --- MAIN DATA SCHEMAS (CustomerData & CustomerInput) ---
 *
 * @OA\Schema(
 * schema="CustomerData",
 * title="Detail Data Pelanggan",
 * description="Representasi lengkap data satu pelanggan dari Accurate.",
 * type="object",
 * properties={
 * @OA\Property(property="referenceCustomerLimitId", type="integer", nullable=true, example=null),
 * @OA\Property(property="consignmentStore", type="boolean", example=false),
 * @OA\Property(property="charField8", type="string", nullable=true, example=null),
 * @OA\Property(property="customerLimitAmountValue", type="number", format="double", example=0),
 * @OA\Property(property="charField9", type="string", nullable=true, example=null),
 * @OA\Property(property="charField6", type="string", nullable=true, example=null),
 * @OA\Property(property="charField7", type="string", nullable=true, example=null),
 * @OA\Property(property="numericField10", type="number", nullable=true, example=null),
 * @OA\Property(property="maxInvoiceAge", type="integer", example=0),
 * @OA\Property(property="idCard", type="string", nullable=true, example=null),
 * @OA\Property(property="charField4", type="string", nullable=true, example=null),
 * @OA\Property(property="charField5", type="string", nullable=true, example=null),
 * @OA\Property(property="optLock", type="integer", example=1),
 * @OA\Property(property="defaultIncTax", type="boolean", example=false),
 * @OA\Property(property="storeCategoryList", type="array", @OA\Items(ref="#/components/schemas/CustomerStoreCategoryItem"), description="Daftar kategori toko pelanggan."),
 * @OA\Property(property="charField2", type="string", nullable=true, example=null),
 * @OA\Property(property="priceCategory", ref="#/components/schemas/CustomerPriceCategory"),
 * @OA\Property(property="charField3", type="string", nullable=true, example=null),
 * @OA\Property(property="charField1", type="string", nullable=true, example=null),
 * @OA\Property(property="id", type="integer", example=2051),
 * @OA\Property(property="salesman3Id", type="integer", nullable=true, example=null),
 * @OA\Property(property="currencyId", type="integer", example=50),
 * @OA\Property(property="fax", type="string", nullable=true, example=null),
 * @OA\Property(property="customerDownPaymentAccountList", type="array", @OA\Items(ref="#/components/schemas/CustomerDownPaymentAccountItem"), description="Daftar akun uang muka pelanggan."),
 * @OA\Property(property="documentCodeName", type="string", example="Digunggung"),
 * @OA\Property(property="discountCategory", ref="#/components/schemas/CustomerDiscountCategory"),
 * @OA\Property(property="dateField2", type="string", format="date-time", nullable=true, example=null),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=null),
 * @OA\Property(property="shipSameAsBill", type="boolean", example=true),
 * @OA\Property(property="customerTaxTypeName", type="string", example="01 - Bukan Pemungut PPN"),
 * @OA\Property(property="dateField1", type="string", format="date-time", nullable=true, example=null),
 * @OA\Property(property="taxCity", type="string", example=""),
 * @OA\Property(property="pkpNo", type="string", nullable=true, example=null),
 * @OA\Property(property="npwpNo", type="string", nullable=true, example=null),
 * @OA\Property(property="groupCustomerLimitOption", type="string", example="FALSE"),
 * @OA\Property(property="documentTransaction", type="string", nullable=true, example=null),
 * @OA\Property(property="suspended", type="boolean", example=false),
 * @OA\Property(property="mobilePhone", type="string", nullable=true, example=null),
 * @OA\Property(property="warehouseId", type="integer", nullable=true, example=null),
 * @OA\Property(property="detailContact", type="array", @OA\Items(ref="#/components/schemas/DetailContactItem"), description="Daftar detail kontak pelanggan."),
 * @OA\Property(property="lastUpdate", type="string", example="30/05/2025 15:36:11", description="Tanggal dan waktu pembaruan terakhir."),
 * @OA\Property(property="defaultInvoiceDesc", type="string", nullable=true, example=null),
 * @OA\Property(property="charField10", type="string", nullable=true, example=null),
 * @OA\Property(property="shipStreet", type="string", example=""),
 * @OA\Property(property="shipProvince", type="string", example=""),
 * @OA\Property(property="shippingAreaDetailList", type="array", @OA\Items(ref="#/components/schemas/CustomerShippingAreaDetailItem"), description="Daftar detail area pengiriman."),
 * @OA\Property(property="countryCode", type="string", nullable=true, example=null),
 * @OA\Property(property="billZipCode", type="string", example=""),
 * @OA\Property(property="billCountry", type="string", example=""),
 * @OA\Property(property="currency", ref="#/components/schemas/CustomerCurrency"),
 * @OA\Property(property="term", ref="#/components/schemas/CustomerTerm"),
 * @OA\Property(property="wpName", type="string", example="Apenstore Indonesia"),
 * @OA\Property(property="shipZipCode", type="string", example=""),
 * @OA\Property(property="email", type="string", format="email", nullable=true, example=null),
 * @OA\Property(property="createDate", type="string", example="30/05/2025 15:36:11", description="Tanggal dan waktu pembuatan."),
 * @OA\Property(property="customerLimitAgeValue", type="integer", nullable=true, example=null),
 * @OA\Property(property="defaultWarehouse", type="string", nullable=true, example=null),
 * @OA\Property(property="website", type="string", format="url", nullable=true, example=null),
 * @OA\Property(property="billStreet", type="string", example=""),
 * @OA\Property(property="salesman2Id", type="integer", nullable=true, example=null),
 * @OA\Property(property="defaultSalesmanId", type="integer", nullable=true, example=null),
 * @OA\Property(property="priceCategoryId", type="integer", example=50),
 * @OA\Property(property="reseller", type="boolean", example=false),
 * @OA\Property(property="detailShipAddress", type="array", @OA\Items(ref="#/components/schemas/DetailShipAddressItem"), description="Daftar detail alamat pengiriman."),
 * @OA\Property(property="defaultSalesDisc", type="string", nullable=true, example=null),
 * @OA\Property(property="taxCountry", type="string", example=""),
 * @OA\Property(property="nitku", type="string", nullable=true, example=null),
 * @OA\Property(property="taxProvince", type="string", example=""),
 * @OA\Property(property="customerLimitAmount", type="boolean", example=false),
 * @OA\Property(property="documentCode", type="string", example="DIGUNGGUNG"),
 * @OA\Property(property="notes", type="string", nullable=true, example=null),
 * @OA\Property(property="childCustomerLimitGroupList", type="array", @OA\Items(type="object"), description="Daftar grup limit pelanggan anak (skema tidak didefinisikan).", example={}),
 * @OA\Property(property="editBranchExistInAvailableBranch", type="boolean", example=true),
 * @OA\Property(property="customerLimitAge", type="boolean", example=false),
 * @OA\Property(property="groupCustomerLimit", type="boolean", example=false),
 * @OA\Property(property="customerBranchName", type="string", example="[Semua Cabang]"),
 * @OA\Property(property="referenceCustomerLimit", type="string", nullable=true, example=null),
 * @OA\Property(property="salesman5Id", type="integer", nullable=true, example=null),
 * @OA\Property(property="detailOpenBalance", type="array", @OA\Items(ref="#/components/schemas/DetailOpenBalanceItem"), description="Daftar detail saldo awal pelanggan."),
 * @OA\Property(property="defaultTermId", type="integer", example=100),
 * @OA\Property(property="taxZipCode", type="string", example=""),
 * @OA\Property(property="name", type="string", example="Apenstore Indonesia"),
 * @OA\Property(property="salesman", type="string", nullable=true, example=null),
 * @OA\Property(property="balanceList", type="array", @OA\Items(ref="#/components/schemas/CustomerBalanceItem"), description="Daftar saldo berdasarkan mata uang."),
 * @OA\Property(property="notesIdTax", type="string", nullable=true, example=null),
 * @OA\Property(property="detailResellerUser", type="array", @OA\Items(ref="#/components/schemas/CustomerDetailResellerUserItem"), description="Daftar detail pengguna reseller."),
 * @OA\Property(property="shipCountry", type="string", example=""),
 * @OA\Property(property="shipAddressId", type="integer", example=2101),
 * @OA\Property(property="salesmanList", type="array", @OA\Items(ref="#/components/schemas/CustomerSalesmanItem"), description="Daftar salesman terkait."),
 * @OA\Property(property="customerTaxType", type="string", example="BKN_PEMUNGUT_PPN"),
 * @OA\Property(property="salesman4Id", type="integer", nullable=true, example=null),
 * @OA\Property(property="customerReceivableAccountList", type="array", @OA\Items(ref="#/components/schemas/CustomerReceivableAccountItem"), description="Daftar akun piutang pelanggan."),
 * @OA\Property(property="taxSameAsBill", type="boolean", example=true),
 * @OA\Property(property="shipCity", type="string", example=""),
 * @OA\Property(property="taxAddressId", type="integer", example=2101),
 * @OA\Property(property="defaultWarehouseId", type="integer", nullable=true, example=null),
 * @OA\Property(property="billAddressId", type="integer", example=2101),
 * @OA\Property(property="billCity", type="string", example=""),
 * @OA\Property(property="customerNoVa", type="string", nullable=true, example=null),
 * @OA\Property(property="billProvince", type="string", example=""),
 * @OA\Property(property="numericField9", type="number", nullable=true, example=null),
 * @OA\Property(property="numericField8", type="number", nullable=true, example=null),
 * @OA\Property(property="taxStreet", type="string", example=""),
 * @OA\Property(property="numericField7", type="number", nullable=true, example=null),
 * @OA\Property(property="numericField6", type="number", nullable=true, example=null),
 * @OA\Property(property="numericField5", type="number", nullable=true, example=null),
 * @OA\Property(property="numericField4", type="number", nullable=true, example=null),
 * @OA\Property(property="efakturSendEmail", type="boolean", nullable=true, example=null),
 * @OA\Property(property="numericField3", type="number", nullable=true, example=null),
 * @OA\Property(property="numericField2", type="number", nullable=true, example=null),
 * @OA\Property(property="workPhone", type="string", nullable=true, example=null),
 * @OA\Property(property="bbmPin", type="string", nullable=true, example=null),
 * @OA\Property(property="numericField1", type="number", nullable=true, example=null),
 * @OA\Property(property="category", ref="#/components/schemas/CustomerCategory"),
 * @OA\Property(property="customerNo", type="string", example="C.00006"),
 * @OA\Property(property="discountCategoryId", type="integer", example=50),
 * @OA\Property(property="categoryId", type="integer", example=51)
 * },
 * required={"id", "optLock", "suspended", "name", "createDate", "lastUpdate", "customerNo", "consignmentStore", "customerLimitAmountValue", "maxInvoiceAge", "defaultIncTax", "customerTaxTypeName", "shipSameAsBill", "groupCustomerLimitOption", "customerLimitAmount", "documentCode", "editBranchExistInAvailableBranch", "customerLimitAge", "groupCustomerLimit", "customerBranchName", "priceCategoryId", "reseller", "taxSameAsBill", "billAddressId", "taxAddressId", "shipAddressId", "currencyId", "defaultTermId", "categoryId", "discountCategoryId"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerInput",
 * title="Input Data Pelanggan (Lengkap)",
 * description="Skema lengkap untuk data input saat membuat atau memperbarui pelanggan. 'id' bersifat opsional untuk buat, wajib untuk update.",
 * type="object",
 * properties={
 * @OA\Property(property="id", type="integer", nullable=true, example=101, description="ID unik internal pelanggan. Diperlukan untuk operasi update, null/kosong untuk create."),
 * @OA\Property(property="name", type="string", example="PT. ABC", description="Nama pelanggan."),
 * @OA\Property(property="transDate", type="string", example="31/03/2016", description="Tanggal transaksi (DD/MM/YYYY)."),
 * @OA\Property(property="billCity", type="string", nullable=true, example="Jakarta", description="Kota alamat penagihan."),
 * @OA\Property(property="billCountry", type="string", nullable=true, example="Indonesia", description="Negara alamat penagihan."),
 * @OA\Property(property="billProvince", type="string", nullable=true, example="DKI Jakarta", description="Provinsi alamat penagihan."),
 * @OA\Property(property="billStreet", type="string", nullable=true, example="Jl. Merdeka No.1", description="Jalan alamat penagihan."),
 * @OA\Property(property="billZipCode", type="string", nullable=true, example="10110", description="Kode pos alamat penagihan."),
 * @OA\Property(property="branchId", type="integer", nullable=true, example=1, description="ID cabang terkait."),
 * @OA\Property(property="branchName", type="string", nullable=true, example="Cabang Jakarta", description="Nama cabang."),
 * @OA\Property(property="categoryName", type="string", nullable=true, example="Grosir", description="Nama kategori pelanggan."),
 * @OA\Property(property="consignmentStore", type="boolean", nullable=true, example=true, description="Menunjukkan apakah ini toko konsinyasi."),
 * @OA\Property(property="currencyCode", type="string", nullable=true, example="IDR", description="Kode mata uang default pelanggan."),
 * @OA\Property(property="customerDownPaymentAccountListNo", type="array", nullable=true, @OA\Items(type="string"), example={"DP-001", "DP-002"}, description="Daftar nomor akun uang muka pelanggan."),
 * @OA\Property(property="customerLimitAge", type="boolean", nullable=true, example=true, description="Menunjukkan apakah ada batasan umur pelanggan."),
 * @OA\Property(property="customerLimitAgeValue", type="integer", nullable=true, example=30, description="Nilai batasan umur pelanggan (dalam hari)."),
 * @OA\Property(property="customerLimitAmount", type="boolean", nullable=true, example=true, description="Menunjukkan apakah ada batasan jumlah kredit pelanggan."),
 * @OA\Property(property="customerLimitAmountValue", type="number", format="double", nullable=true, example=100000000.50, description="Nilai batasan jumlah kredit pelanggan."),
 * @OA\Property(property="customerNo", type="string", nullable=true, example="CUST-001", description="Nomor pelanggan eksternal."),
 * @OA\Property(property="customerReceivableAccountListNo", type="array", nullable=true, @OA\Items(type="string"), example={"AR-001", "AR-002"}, description="Daftar nomor akun piutang pelanggan."),
 * @OA\Property(
 * property="customerTaxType",
 * type="string",
 * enum={
 * "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
 * "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH",
 * "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH",
 * "CTAS_EKSPOR_BARANG_BERWUJUD",
 * "CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD",
 * "CTAS_EKSPOR_JASA",
 * "CTAS_DPP_NILAI_LAIN",
 * "CTAS_BESARAN_TERTENTU",
 * "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI",
 * "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT",
 * "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN",
 * "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN"
 * },
 * example="CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
 * description="Tipe pajak pelanggan."
 * ),
 * @OA\Property(property="defaultIncTax", type="boolean", nullable=true, example=true, description="Termasuk pajak secara default."),
 * @OA\Property(property="defaultSalesDisc", type="string", nullable=true, example="5+2", description="Diskon penjualan default."),
 * @OA\Property(property="description", type="string", nullable=true, example="Pelanggan utama sejak 2020", description="Deskripsi atau catatan pelanggan."),
 * @OA\Property(property="detailContact", type="array", nullable=true, @OA\Items(ref="#/components/schemas/DetailContactItem"), description="Daftar detail kontak pelanggan."),
 * @OA\Property(property="detailOpenBalance", type="array", nullable=true, @OA\Items(ref="#/components/schemas/DetailOpenBalanceItem"), description="Daftar detail saldo awal pelanggan."),
 * @OA\Property(property="detailShipAddress", type="array", nullable=true, @OA\Items(ref="#/components/schemas/DetailShipAddressItem"), description="Daftar detail alamat pengiriman pelanggan."),
 * @OA\Property(property="discountCategoryName", type="string", nullable=true, example="Diskon Khusus", description="Nama kategori diskon."),
 * @OA\Property(property="email", type="string", format="email", nullable=true, example="customer@example.com", description="Email utama pelanggan."),
 * @OA\Property(property="fax", type="string", nullable=true, example="021-7654321", description="Nomor Fax utama pelanggan."),
 * @OA\Property(property="mobilePhone", type="string", nullable=true, example="081298765432", description="Nomor telepon seluler utama pelanggan."),
 * @OA\Property(property="notes", type="string", nullable=true, example="Pelanggan prioritas", description="Catatan internal tentang pelanggan."),
 * @OA\Property(property="npwpNo", type="string", nullable=true, example="01.234.567.8-901.000", description="Nomor NPWP pelanggan."),
 * @OA\Property(property="number", type="string", nullable=true, example="INV-20240617-001", description="Nomor unik dokumen (jika relevan)."),
 * @OA\Property(property="pkpNo", type="string", nullable=true, example="PKP-12345", description="Nomor PKP pelanggan."),
 * @OA\Property(property="priceCategoryName", type="string", nullable=true, example="Harga Grosir", description="Nama kategori harga."),
 * @OA\Property(property="salesmanListNumber", type="array", nullable=true, @OA\Items(type="string"), example={"SM-001", "SM-002"}, description="Daftar nomor salesman terkait."),
 * @OA\Property(property="salesmanNumber", type="string", nullable=true, example="SM-001", description="Nomor salesman utama."),
 * @OA\Property(property="shipCity", type="string", nullable=true, example="Jakarta", description="Kota alamat pengiriman."),
 * @OA\Property(property="shipCountry", type="string", nullable=true, example="Indonesia", description="Negara alamat pengiriman."),
 * @OA\Property(property="shipProvince", type="string", nullable=true, example="DKI Jakarta", description="Provinsi alamat pengiriman."),
 * @OA\Property(property="shipSameAsBill", type="boolean", nullable=true, example=false, description="Alamat pengiriman sama dengan penagihan."),
 * @OA\Property(property="shipStreet", type="string", nullable=true, example="Jl. Gajah Mada No.5", description="Jalan alamat pengiriman."),
 * @OA\Property(property="shipZipCode", type="string", nullable=true, example="10130", description="Kode pos alamat pengiriman."),
 * @OA\Property(property="taxCity", type="string", nullable=true, example="Jakarta", description="Kota alamat pajak."),
 * @OA\Property(property="taxCountry", type="string", nullable=true, example="Indonesia", description="Negara alamat pajak."),
 * @OA\Property(property="taxProvince", type="string", nullable=true, example="DKI Jakarta", description="Provinsi alamat pajak."),
 * @OA\Property(property="taxSameAsBill", type="boolean", nullable=true, example=true, description="Alamat pajak sama dengan penagihan."),
 * @OA\Property(property="taxStreet", type="string", nullable=true, example="Jl. Merdeka No.1", description="Jalan alamat pajak."),
 * @OA\Property(property="taxZipCode", type="string", nullable=true, example="10110", description="Kode pos alamat pajak."),
 * @OA\Property(property="termName", type="string", nullable=true, example="Net 30", description="Nama syarat pembayaran."),
 * @OA\Property(property="typeAutoNumber", type="integer", nullable=true, example=2, description="Tipe nomor otomatis."),
 * @OA\Property(property="website", type="string", format="url", nullable=true, example="http://customer-website.com", description="Alamat situs web pelanggan."),
 * @OA\Property(property="workPhone", type="string", nullable=true, example="021-7654321", description="Nomor telepon kantor pelanggan."),
 * @OA\Property(property="wpName", type="string", nullable=true, example="John Doe", description="Nama wajib pajak.")
 * },
 * required={"name", "transDate"}
 * )
 *
 * --- RESPONSE SCHEMAS ---
 *
 * @OA\Schema(
 * schema="CustomerListResponse",
 * title="Respons Daftar Pelanggan",
 * description="Struktur respons untuk daftar pelanggan dengan informasi paginasi.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true, description="Menunjukkan apakah permintaan berhasil."),
 * @OA\Property(property="status", type="integer", example=200, description="Kode status HTTP."),
 * @OA\Property(property="data", type="object", description="Objek data utama",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Indikator keberhasilan dari Accurate API."),
 * @OA\Property(property="d", type="array", @OA\Items(ref="#/components/schemas/CustomerData"), description="Array daftar objek pelanggan."),
 * @OA\Property(property="sp", type="object", description="Informasi paginasi",
 * properties={
 * @OA\Property(property="page", type="integer", example=1),
 * @OA\Property(property="pageSize", type="integer", example=50),
 * @OA\Property(property="pageCount", type="integer", example=10),
 * @OA\Property(property="rowCount", type="integer", example=487),
 * @OA\Property(property="start", type="integer", example=0)
 * }
 * )
 * }
 * )
 * },
 * required={"success", "status", "data"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerFormAttributesResponse",
 * title="Atribut Form Pelanggan",
 * description="Daftar opsi dan atribut yang diperlukan untuk form pembuatan/pengeditan pelanggan.",
 * type="object",
 * properties={
 * @OA\Property(
 * property="customerTaxTypeOptions",
 * type="array",
 * @OA\Items(
 * type="string",
 * enum={
 * "CTAS_KEPADA_SELAIN_PEMUNGUT_PPN",
 * "CTAS_KEPADA_PEMUNGUT_PPN_INSTANSI_PEMERINTAH",
 * "CTAS_KEPADA_PEMUNGUT_PPN_SELAIN_INSTANSI_PEMERINTAH",
 * "CTAS_EKSPOR_BARANG_BERWUJUD",
 * "CTAS_EKSPOR_BARANG_TIDAK_BERWUJUD",
 * "CTAS_EKSPOR_JASA",
 * "CTAS_DPP_NILAI_LAIN",
 * "CTAS_BESARAN_TERTENTU",
 * "CTAS_KEPADA_ORANG_PRIBADI_PEMEGANG_PASPOR_LUAR_NEGERI",
 * "CTAS_PENYERAHAN_DENGAN_FASILITAS_TIDAK_DIPUNGUT",
 * "CTAS_PENYERAHAN_DENGAN_FASILITAS_DIBEBASKAN",
 * "CTAS_PENYERAHAN_AKTIVA_TIDAK_DIPERJUALBELIKAN"
 * }
 * ),
 * description="Opsi tipe pajak pelanggan."
 * ),
 * @OA\Property(property="ContactSalutationTypeOptions", type="array", @OA\Items(type="string", enum={"MR", "MRS"}), description="Opsi sapaan kontak.")
 * },
 * required={"customerTaxTypeOptions", "ContactSalutationTypeOptions"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerDetailResponse",
 * title="Respons Detail Pelanggan",
 * description="Struktur respons untuk detail pelanggan tunggal.",
 * type="object",
 * properties={
 * @OA\Property(property="success", type="boolean", example=true),
 * @OA\Property(property="status", type="integer", example=200),
 * @OA\Property(property="data", ref="#/components/schemas/CustomerData", description="Objek data pelanggan.")
 * },
 * required={"success", "status", "data"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerEditResponse",
 * title="Respons Edit Pelanggan",
 * description="Struktur respons yang menggabungkan detail pelanggan dan atribut form untuk pengeditan.",
 * type="object",
 * properties={
 * @OA\Property(property="data_edit", ref="#/components/schemas/CustomerData", description="Data pelanggan yang akan diedit."),
 * @OA\Property(property="form_attribute", ref="#/components/schemas/CustomerFormAttributesResponse", description="Atribut form untuk pengeditan.")
 * },
 * required={"data_edit", "form_attribute"}
 * )
 *
 * @OA\Schema(
 * schema="CustomerSaveUpdateDeleteResponse",
 * title="Respons Sukses Generik",
 * description="Respons umum untuk operasi simpan, update, atau hapus yang berhasil.",
 * type="object",
 * properties={
 * @OA\Property(property="s", type="boolean", example=true, description="Status sukses dari Accurate API."),
 * @OA\Property(property="m", type="string", example="Data berhasil disimpan.", description="Pesan dari Accurate API."),
 * @OA\Property(property="d", type="integer", example=101, description="ID objek yang baru dibuat/diperbarui/dihapus (opsional).", nullable=true)
 * },
 * required={"s", "m"}
 * )
 */
class CustomerSchemas
{
    // Kelas ini hanya menampung anotasi Schema
}
