<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
  public function getProvinces()
	{
		try {
			$dataProvinces = DB::table('provinces')->get();

			return response()->json([
				'message' => 'Berhasil mengambil data provinsi',
				'serve' => $dataProvinces
			], 200);
 		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
			], 500);
		}
	}

  public function getCities(Request $request)
	{
		try {
			$dataCities = DB::table('cities')
				->where('province_id', $request->get('provinceId'))
				->get(['id', 'name']);

			return response()->json([
				'message' => 'Berhasil mengambil data kota',
				'serve' => $dataCities
			], 200);
 		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
			], 500);
		}
	}

	public function getDistricts(Request $request)
	{
		try {
			$dataDistricts = DB::table('districts')
				->where('city_id', $request->get('cityId'))
				->get(['id', 'name']);

			return response()->json([
				'message' => 'Berhasil mengambil data kecamatan',
				'serve' => $dataDistricts
			], 200);
 		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
			], 500);
		}
	}

	public function getSubDistricts(Request $request)
	{
		try {
			$dataSubDistricts = DB::table('sub_districts')
				->where('district_id', $request->get('districtId'))
				->get(['id', 'name']);

			return response()->json([
				'message' => 'Berhasil mengambil data kelurahan',
				'serve' => $dataSubDistricts
			], 200);
 		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
			], 500);
		}
	}
}
