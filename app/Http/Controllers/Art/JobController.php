<?php

namespace App\Http\Controllers\Art;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Art;
use App\Models\ArtInterestedJob;
use Illuminate\Contracts\Queue\Job;
use Psy\Command\HistoryCommand;

class JobController extends Controller
{
	public function getJob(Request $request)
	{
		try {
			$jobVacancy = JobVacancy::select([
				'job_vacancy.id as job_vacancy_id',
				'job_vacancy.art_finder_id',
				'job_vacancy.photo_id',
				'job_vacancy.job_payment'
			])
				->join('art_finder', 'art_finder.id', '=', 'job_vacancy.art_finder_id')
				->when($request->get('province_id'), function($query) use($request) {
					return $query->where('art_finder.province_id', $request->get('province_id'));
				})
				->when($request->get('city_id'), function($query) use($request) {
					return $query->where('art_finder.city_id', $request->get('city_id'));
				})
				->with([
					'photo:id,photo_url',
					'artFinder:id,province_id,city_id,art_finder_name',
					'artFinder.province:id,name',
					'artFinder.city:id,name'
				])
				->visibleJobVacancy()
				->stillAvailable()
				->paginate(20);

			return response()->json([
				'message' => 'Berhasil mengambil data lowongan',
				'serve' => $jobVacancy
			], 200);
		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
				'serve' => []
			], 500);
		}
	}

	public function getDetailJob($jobId)
	{
		try {
			$jobVacancy = JobVacancy::select([
				'job_vacancy.id as job_vacancy_id',
				'job_vacancy.art_finder_id',
				'job_vacancy.photo_id',
				'job_vacancy.job_payment',
				'job_vacancy.job_description',
				'job_vacancy.job_due_date'
			])
				->join('art_finder', 'art_finder.id', '=', 'job_vacancy.art_finder_id')
				->with([
					'photo:id,photo_url',
					'artFinder:id,province_id,city_id,district_id,sub_district_id,art_finder_name',
					'artFinder.province:id,name',
					'artFinder.city:id,name',
					'artFinder.district:id,name',
					'artFinder.subDistrict:id,name'
				])
				->find($jobId);

			return response()->json([
				'message' => 'Berhasil mengambil detail lowongan',
				'serve' => $jobVacancy
			], 200);
		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
				'serve' => []
			], 500);
		}
	}

	public function historyApplyJob(Request $request)
	{
		try {
			$art = Art::select('id')->where('user_id', $request->user()->id)->first();

			$historyApplyJob = ArtInterestedJob::select([
				'art_interested_job.job_vacancy_id',
				'art_interested_job.apply_status',
			])
				->with([
					'jobVacancy:id,art_finder_id,photo_id',
					'jobVacancy.photo:id,photo_url',
					'jobVacancy.artFinder:id,art_finder_name'
				])
				->where('art_id', $art['id'])
				->when($request->get('apply_status') != '-1', function($query) use($request) {
					return $query->where('apply_status', $request->get('apply_status'));
				})
				->get();

			return response()->json([
				'message' => 'Berhasil mengambil history',
				'serve' => $historyApplyJob
			], 200);

		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
				'serve' => []
			], 500);
		}
	}

	public function applyJob(Request $request, $jobId)
	{
		try {
			$art = Art::select(['id', 'art_job_status'])->where('user_id', $request->user()->id)->first();

			if ($art['art_job_status']) {
				return response()->json([
					'message' => 'Maaf status anda sekarang sedang bekerja',
					'serve' => [],
				], 400);
			}

			$isAlreadyApply = ArtInterestedJob::where('job_vacancy_id', $jobId)->where('art_id', $art->id)->exists();

			if ($isAlreadyApply) {
				return response()->json([
					'message' => 'Maaf anda sudah mendaftar ke lowongan ini',
					'serve' => []
				], 400);
			}

			$artInterestedJob = new ArtInterestedJob;
			$artInterestedJob->art_id = $art['id'];
			$artInterestedJob->job_vacancy_id = $jobId;
			$artInterestedJob->apply_status = 0;
			$artInterestedJob->save();

			return response()->json([
				'message' => 'Berhasil mendaftar ke lowongan ini',
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
