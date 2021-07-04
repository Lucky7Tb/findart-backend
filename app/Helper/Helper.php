<?php

namespace App\Helper;

use Illuminate\Support\Str;
class Helper
{

	public static function saveImage($image, $savePath)
	{
		$newFileName = date('YmdHis') . '-' . $image->getClientOriginalName();
		$newFileName = Str::replace(' ', '', $newFileName);

		$image->move(public_path('disk'), $newFileName);

		$fileUrl = asset('disk/' . $newFileName);

		return $fileUrl;
	}

	public static function deleteImage($urlImage)
	{
		$imagePath = Str::remove(env('APP_URL'), $urlImage);

		if (file_exists(public_path() . $imagePath)) {
			unlink(public_path() . $imagePath);
		}
	}
}
