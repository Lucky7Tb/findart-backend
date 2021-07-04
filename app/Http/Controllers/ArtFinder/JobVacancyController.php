<?php

namespace App\Http\Controllers\ArtFinder;

use App\Models\Photo;
use App\Helper\Helper;
use App\Models\ArtFinder;
use App\Models\JobVacancy;
use App\Models\ArtInterestedJob;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Http\Requests\ChangeJobThumbnailRequest;
class JobVacancyController extends Controller
{
  public function getJob()
  {
  	try {
  		$dataJobVacancy = JobVacancy::select([
				'id', 'photo_id', 'job_payment', 'job_due_date', 'updated_at'
			])
				->myJobVacancy()
				->visibleJobVacancy()
				->with('photo:id,photo_url')
				->simplePaginate(10);

  		return response()->json([
  			'message' => 'Berhasil mengambil lowongan kerja',
  			'serve' => $dataJobVacancy
  		], 200);
  	} catch(\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: '. $e->getFile() . ' ' . $e->getLine());

			return response()->json([
  			'message' => 'Terjadi kesalahan pada server',
  			'serve' => []
  		], 500);
  	}
  }

  public function getDetailJob($jobId)
  {
  	try {
  		$dataJobVacancy = JobVacancy::select([
				'id', 'photo_id', 'job_description', 'job_payment', 'job_due_date'
			])
				->visibleJobVacancy()
				->find($jobId);

  		if ($dataJobVacancy == null) {
  			return response()->json([
  				'message' => 'Lowongan perkejaan tidak ditemukan',
  				'serve' => [],
  			], 404);
  		}

  		return response()->json([
  			'message' => 'Berhasil mengambil lowongan kerja',
  			'serve' => $dataJobVacancy
  		], 200);

  	} catch(\Exception $e) {
  		Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: '. $e->getFile() . ' ' . $e->getLine());

			return response()->json([
  			'message' => 'Terjadi kesalahan pada server',
  			'serve' => []
  		], 500);
  	}
  }

  public function getInterestedArt($jobId)
  {
  	try {
  		$interestedArt = ArtInterestedJob::select(['art_id'])
				->with(['art:id,photo_id,art_name', 'art.artRating', 'art.photo:id,photo_url'])
				->where('art_interested_job.job_vacancy_id', $jobId)
				->get();

  		return response()->json([
  			'message' => 'Berhasil mengambil art yang tertarik',
  			'serve' => $interestedArt
  		], 200);

  	} catch(\Exception $e) {
  		Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: '. $e->getFile() . ' ' . $e->getLine());

			return response()->json([
  			'message' => 'Terjadi kesalahan pada server',
  			'serve' => []
  		], 500);
  	}
  }

  public function createJob(JobVacancyCreateRequest $request)
  {
  	try {
			$data = $request->validated();

			$artFinder = ArtFinder::select('id')->where('user_id', auth()->user()->id)->first();

			$fileUrl = Helper::saveImage($data['job_thumbnail'], 'public/images');

			$photo = new Photo;
			$photo->photo_url = $fileUrl;
			$photo->save();

			$jobVacancy = new JobVacancy;
			$jobVacancy->art_finder_id = $artFinder['id'];
			$jobVacancy->photo_id = $photo->id;
			$jobVacancy->job_description = $data['job_description'];
			$jobVacancy->job_payment = $data['job_payment'];
			$jobVacancy->job_due_date = $data['job_due_date'];
			$jobVacancy->is_visible = 1;
			$jobVacancy->save();

			return response()->json([
				'message' => 'Berhasil menambah lowongan',
				'serve' => []
			], 201);

  	} catch(\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: '. $e->getFile() . ' ' . $e->getLine());

			return response()->json([
  			'message' => 'Terjadi kesalahan pada server',
  			'serve' => []
  		], 500);
  	}
  }

  public function updateJob(JobVacancyUpdateRequest $request, $jobId)
  {
  	try {
  		$data = $request->validated();
  		$jobVacancy = JobVacancy::find($jobId);

  		if ($jobVacancy == null) {
  			return response()->json([
  				'message' => 'Lowongan perkejaan tidak ditemukan',
  				'serve' => [],
  			], 404);
  		}

  		$jobVacancy->job_description = $data['job_description'];
			$jobVacancy->job_payment = $data['job_payment'];
			$jobVacancy->job_due_date = $data['job_due_date'];
			$jobVacancy->save();

			return response()->json([
				'message' => 'Berhasil mengubah data lowongan',
				'serve' => []
			], 200);

  	} catch(\Exception $e) {
  		Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: '. $e->getFile() . ' ' . $e->getLine());

			return response()->json([
  			'message' => 'Terjadi kesalahan pada server',
  			'serve' => []
  		], 500);
  	}
  }

  public function changeJobThumbnail(ChangeJobThumbnailRequest $request , $jobId)
  {
		try {
			$data = $request->validated();
			$jobVacancy = JobVacancy::select(['photo_id'])->find($jobId);

			if ($jobVacancy == null) {
  			return response()->json([
  				'message' => 'Lowongan perkejaan tidak ditemukan',
  				'serve' => [],
  			], 404);
  		}

  		$photoId = $jobVacancy['photo_id'];
			$photo = Photo::find($photoId);

			$fileUrl = Helper::saveImage($data['job_thumbnail'], 'public/images');

			Helper::deleteImage($photo->photo_url);

			$photo->photo_url = $fileUrl;
			$photo->save();

			return response()->json([
				'message' => 'Berhasil mengubah thumbnail',
				'serve' => []
			], 200);

  	} catch(\Exception $e) {
  		Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: '. $e->getFile() . ' ' . $e->getLine());

			return response()->json([
  			'message' => 'Terjadi kesalahan pada server',
  			'serve' => []
  		], 500);
  	}
  }

  public function deleteJob($jobId)
  {
  	try {
  		$jobVacancy = JobVacancy::find($jobId);

  		if($jobVacancy == null) {
  			return response()->json([
  				'message' => 'Lowongan perkejaan tidak ditemukan',
  				'serve' => [],
  			], 404);
  		}

  		$photoId = $jobVacancy['photo_id'];
			$photo = Photo::find($photoId);

			$jobVacancy->delete();

			Helper::deleteImage($photo->photo_url);
			$photo->delete();

			return response()->json([
				'message' => 'Berhasil mengahapus lowongan pekerjaan',
				'serve' => []
			], 200);

  	} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: '. $e->getFile() . ' ' . $e->getLine());

			return response()->json([
  			'message' => 'Terjadi kesalahan pada server',
  			'serve' => []
  		], 500);  	}
  }
}
