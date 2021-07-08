<?php
use Illuminate\Support\Facades\Route;

Route::prefix('location')->group(function() {
	Route::get('/provinces', [\App\Http\Controllers\LocationController::class, 'getProvinces']);
	Route::get('/cities', [\App\Http\Controllers\LocationController::class, 'getCities']);
	Route::get('/districts', [\App\Http\Controllers\LocationController::class, 'getDistricts']);
	Route::get('/sub_districts', [\App\Http\Controllers\LocationController::class, 'getSubDistricts']);
});

Route::prefix('auth')->group(function() {
	Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
	Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
	Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::prefix('finder')->middleware('auth:sanctum')->group(function() {
	Route::prefix('job')->group(function() {
		Route::get('/', [\App\Http\Controllers\ArtFinder\JobVacancyController::class, 'getJob']);
		Route::get('/{jobId}', [\App\Http\Controllers\ArtFinder\JobVacancyController::class, 'getDetailJob']);
		Route::get('/interested-art/{jobId}', [\App\Http\Controllers\ArtFinder\JobVacancyController::class, 'getInterestedArt']);
		Route::post('/create-job', [\App\Http\Controllers\ArtFinder\JobVacancyController::class, 'createJob']);
		Route::post('/change-thumbnail/{jobId}', [\App\Http\Controllers\ArtFinder\JobVacancyController::class, 'changeJobThumbnail']);
		Route::post('/update-job/{jobId}', [\App\Http\Controllers\ArtFinder\JobVacancyController::class, 'updateJob']);
		Route::post('/delete-job/{jobId}', [\App\Http\Controllers\ArtFinder\JobVacancyController::class, 'deleteJob']);
	});

	Route::prefix('art')->group(function() {
		Route::get('/', [\App\Http\Controllers\ArtFinder\ArtController::class, 'getMyArt']);
		Route::get('/{artId}', [\App\Http\Controllers\ArtFinder\ArtController::class, 'getDetailArt']);
		Route::post('/', [\App\Http\Controllers\ArtFinder\ArtController::class, 'selectArt']);
		Route::post('/fire-art', [\App\Http\Controllers\ArtFinder\ArtController::class, 'fireArt']);
	});

	Route::prefix('setting')->group(function(){
		Route::post('/change-photo', [\App\Http\Controllers\ArtFinder\SettingController::class, 'changePhotoProfile']);
		Route::post('/change-profile', [\App\Http\Controllers\ArtFinder\SettingController::class, 'changeProfile']);
		Route::post('/change-password', [\App\Http\Controllers\ArtFinder\SettingController::class, 'changePassword']);
	});
});

Route::prefix('art')->middleware('auth:sanctum')->group(function() {
	Route::prefix('job')->group(function() {
		Route::get('/', [\App\Http\Controllers\Art\JobController::class, 'getJob']);
		Route::get('/applied-job', [\App\Http\Controllers\Art\JobController::class, 'getAppliedJob']);
		Route::get('/{jobId}', [\App\Http\Controllers\Art\JobController::class, 'getDetailJob']);
		Route::post('/apply-job/{jobId}', [\App\Http\Controllers\Art\JobController::class, 'applyJob']);
	});

	Route::prefix('setting')->group(function () {
		Route::post('/change-photo', [\App\Http\Controllers\Art\SettingController::class, 'changePhotoProfile']);
		Route::post('/change-profile', [\App\Http\Controllers\Art\SettingController::class, 'changeProfile']);
		Route::post('/change-password', [\App\Http\Controllers\Art\SettingController::class, 'changePassword']);
	});
});
