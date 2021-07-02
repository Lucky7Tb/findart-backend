<?php

namespace App\Http\Controllers\ArtFinder;

use App\Models\Art;
use App\Models\ArtFinder;
use App\Models\ArtRating;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use App\Models\ArtAcceptedJob;
use App\Models\ArtInterestedJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\FireArtRequest;
use App\Http\Requests\SelectArtRequest;
class ArtController extends Controller
{
	public function getMyArt(Request $request)
	{
		try {
			$artFinder = ArtFinder::select('id')->where('user_id', $request->user()->id)->first();

			$dataMyArt = ArtAcceptedJob::select(['id', 'art_id'])
				->with('art:id,photo_id,art_name,art_phone_number', 'art.photo:id,photo_url')
				->isMyArt($artFinder->id)
				->isAccepted()
				->get();

			return response()->json([
				'message' => 'Berhasil mengambil data art',
				'serve' => $dataMyArt
			], 200);
		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
				'serve' => []
			], 500);
		}
	}

	public function getDetailArt($artId)
	{
		try {
			$dataArt = Art::select([
					'province_id',
					'city_id',
					'district_id',
					'sub_district_id',
					'art_name',
					'art_bio',
					'art_address'
				])
				->with('province:id,name', 'city:id,name', 'district:id,name', 'subDistrict:id,name')
				->where('id', $artId)
				->get();

			if (!$dataArt) {
				return response()->json([
					'message' => 'Art tidak ada',
					'serve' => []
				], 404);
			}

			return response()->json([
				'message' => 'Berhasil mengambil detail art',
				'serve' => $dataArt
			], 200);

		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
				'serve' => []
			], 500);
		}
	}

	public function selectArt(SelectArtRequest $request)
	{
		try {
			$data = $request->validated();

			$art = Art::find($data['art_id']);
			$artFinder = ArtFinder::select('id')->where('user_id', auth()->user()->id)->first();

			$isWorking = $art['art_job_status'];
			$artId = $data['art_id'];

			if ($isWorking) {
				return response()->json([
					'message' => 'Maaf art sudah bekerja. Silahkan pilih art yang lain',
					'serve' => []
				], 400);
			}

			$artInteredtedJob = ArtInterestedJob::where('job_vacancy_id', $data['job_vacancy_id']);
			$artInteredtedJob->update(['apply_status' => DB::raw("IF(art_id != $artId, 1, 2)")]);

			$jobVacancy = JobVacancy::find($data['job_vacancy_id']);
			$jobVacancy->is_visible = 0;
			$jobVacancy->save();

			$art = Art::find($data['art_id']);
			$art->art_job_status = 1;
			$art->save();

			$artAcceptedJob = new ArtAcceptedJob;
			$artAcceptedJob->art_id = $data['art_id'];
			$artAcceptedJob->art_finder_id = $artFinder['id'];
			$artAcceptedJob->job_status = 1;
			$artAcceptedJob->save();

			return response()->json([
				'message' => 'Berhasil memilih art',
				'serve' => []
			], 200);
		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
				'serve' => []
			], 500);
		}
	}

	public function fireArt(FireArtRequest $request)
	{
		try {
			$data = $request->validated();
			$artFinder = ArtFinder::select('id')->where('user_id', auth()->user()->id)->first();

			$artAcceptedJob = ArtAcceptedJob::find($data['accepted_job_id']);
			$artAcceptedJob->job_status = 0;
			$artAcceptedJob->save();

			$artInterestedJob = ArtInterestedJob::where('art_id', $artAcceptedJob->art_id);
			$artInterestedJob->where('apply_status', 2)->update(['apply_status' => 3]);

			$art = Art::find($artAcceptedJob->art_id);
			$art->art_job_status = 0;
			$art->save();

			$artRating = new ArtRating;
			$artRating->art_id = $artAcceptedJob->art_id;
			$artRating->art_finder_id = $artFinder['id'];
			$artRating->rating = $data['art_rating'];
			$artRating->save();

			return response()->json([
				'message' => 'Berhasil memberhentikan art',
				'serve' => []
			], 200);
		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
				'serve' => []
			], 500);
		}
	}
}
