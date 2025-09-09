<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CredentialController extends Controller
{
    /**
     * @OA\Post(
     * path="/login",
     * summary="Login Pengguna",
     * description="Melakukan autentikasi pengguna dengan email dan password, mengembalikan token akses JWT.",
     * operationId="loginUser",
     * tags={"Autentikasi"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * ref="#/components/schemas/LoginInput"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Login berhasil, mengembalikan token akses.",
     * @OA\JsonContent(
     * ref="#/components/schemas/LoginResponse"
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Kredensial tidak valid.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Invalid credentials")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Kesalahan validasi input (misal: email/password kosong).",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="The given data was invalid."),
     * @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}})
     * )
     * ),
     * @OA\Response(
     * response=500,
     * description="Kesalahan internal server."
     * )
     * )
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        }

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration', 1440) * 60,
        ], 200);
    }

    /**
     * @OA\Post(
     * path="/logout",
     * summary="Logout Pengguna",
     * description="Menghapus semua token akses pengguna, secara efektif mengakhiri sesi login.",
     * operationId="logoutUser",
     * tags={"Autentikasi"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Berhasil logout.",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Logged out successfully")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Tidak terautentikasi. Token tidak valid atau tidak tersedia.",
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
    public function logout(Request $request)
    {
        if (!$request->user()) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }

    /**
     * @OA\Get(
     * path="/profile",
     * summary="Mendapatkan Informasi Profil Pengguna",
     * description="Mengambil data profil lengkap dari pengguna yang sedang terautentikasi.",
     * operationId="getUserProfile",
     * tags={"Autentikasi"},
     * security={{"BearerAuth": {}}},
     * @OA\Response(
     * response=200,
     * description="Data profil pengguna berhasil diambil.",
     * @OA\JsonContent(
     * @OA\Property(property="id", type="integer", example=1, description="ID unik pengguna."),
     * @OA\Property(property="name", type="string", example="John Doe", description="Nama lengkap pengguna."),
     * @OA\Property(property="email", type="string", format="email", example="john.doe@example.com", description="Alamat email pengguna."),
     * @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example="2024-01-01T12:00:00.000000Z", description="Timestamp verifikasi email."),
     * @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T10:00:00.000000Z", description="Timestamp pembuatan akun."),
     * @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T11:00:00.000000Z", description="Timestamp terakhir update akun.")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Tidak terautentikasi. Token tidak valid atau tidak tersedia.",
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
    public function user()
    {
        // Laravel Sanctum atau middleware 'auth:sanctum' biasanya sudah menangani otentikasi.
        // Jika kode ini hanya diakses setelah middleware 'auth:sanctum', cek ini bisa opsional.
        // Namun, jika Anda ingin explicit check, tidak masalah.
        if (!Auth::check()) { // Gunakan Auth::check() untuk memeriksa status login
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        // Mengembalikan objek pengguna yang sudah terautentikasi
        return response()->json(Auth::user(), 200);
    }
}
