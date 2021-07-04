<?php

namespace App\Http\Controllers;

use App\Models\Art;
use App\Models\User;
use App\Models\ArtFinder;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
class AuthController extends Controller
{
	public function login(LoginRequest $request)
	{
		$credentials = $request->validated();

		if (Auth::attempt($credentials)) {
			$token = $request->user()->createToken(env('APP_NAME'))->plainTextToken;

			return response()->json([
				'message' => 'Berhasil masuk',
				'serve' => [
					'username' => $credentials['username'],
					'role' => $request->user()->role,
					'AccessToken' => $token,
				]
			], 200);
		}

		return response()->json([
			'message' => 'Akun tidak ditemukan',
			'serve' => []
		], 401);
	}

	public function register(RegisterRequest $request)
	{
		try {
			$data = $request->validated();

			$user = new User;
			$user->username = $data['username'];
			$user->password = $data['password'];
			$user->role = $data['role'];
			$user->save();

			if ($user->role == 'ART') {
				$art = new Art;
				$art->user_id = $user->id;
				$art->city_id = $data['city_id'];
				$art->district_id = $data['district_id'];
				$art->sub_district_id = $data['sub_district_id'];
				$art->photo_id = 1;
				$art->art_phone_number = $data['phone_number'];
				$art->art_address = $data['address'];
				$art->full_name = $data['full_name'];
				$art->job_status = 0;
				$art->save();
			} else {
				$artFinder = new ArtFinder;
				$artFinder->user_id = $user->id;
				$artFinder->city_id = $data['city_id'];
				$artFinder->district_id = $data['district_id'];
				$artFinder->sub_district_id = $data['sub_district_id'];
				$artFinder->photo_id = 1;
				$artFinder->art_finder_phone_number = $data['phone_number'];
				$artFinder->art_finder_address = $data['address'];
				$artFinder->full_name = $data['full_name'];
				$artFinder->save();
			}

			return response()->json([
				'message' => 'Berhasil registrasi',
				'serve' => $user
			], 201);

		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: '. $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
				'serve' => []
			], 500);
		}
	}

	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()->delete();

		return response()->json([
			'message' => 'Berhasil logout'
		], 200);
	}
}
