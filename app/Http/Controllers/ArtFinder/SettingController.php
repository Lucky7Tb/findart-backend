<?php

namespace App\Http\Controllers\ArtFinder;

use App\Models\User;
use App\Models\Photo;
use App\Helper\Helper;
use App\Models\ArtFinder;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangeProfileRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangePhotoProfileRequest;
class SettingController extends Controller
{
  public function changePhotoProfile(ChangePhotoProfileRequest $request)
	{
		try {
			$data = $request->validated();
			$artFinder = ArtFinder::select(['photo_id'])->where('user_id', auth()->user()->id)->first();

			$fileUrl = Helper::saveImage($data['photo'], 'public/images');

			if ($artFinder['photo_id'] !== 1) {
				$photo = Photo::find($artFinder['photo_id']);
				Helper::deleteImage($photo->photo_url);
				$photo->photo_url = $fileUrl;
				$photo->save();
			} else {
				$photo = new Photo;
				$photo->photo_url = $fileUrl;
				$photo->save();

				ArtFinder::where('user_id', auth()->user()->id)->update([
					'photo_id' => $photo->id
				]);
			}

			return response()->json([
				'message' => 'Berhasil mengganti foto profile',
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

	public function changeProfile(ChangeProfileRequest $request)
	{
		try {
			$data = $request->validated();

			$artFinder = ArtFinder::where('user_id', auth()->user()->id);
			$artFinder->update([
				'art_finder_phone_number' => $data['phone_number'],
				'art_finder_address' =>  $data['address']
			]);

			return response()->json([
				'message' => 'Berhasil mengubah profile',
			], 200);
		} catch (\Exception $e) {
			Log::error('Error: code: ' . $e->getCode() . ', ' . $e->getMessage() . ' on file: ' . $e->getFile() . ' ' . $e->getLine());

			return response()->json([
				'message' => 'Terjadi kesalahan pada server',
				'serve' => []
			], 500);
		}
	}

	public function changePassword(ChangePasswordRequest $request)
	{
		try {
			$data = $request->validated();

			$user = User::find(auth()->user()->id);

			$isSame = Hash::check($data['old_password'], $user->password);

			if (!$isSame) {
				return response()->json([
					'message' => 'Password lama anda salah',
					'serve' => []
				], 400);
			}

			$user->password = $data['new_password'];
			$user->save();

			return response()->json([
				'message' => 'Berhasil mengubah password',
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
