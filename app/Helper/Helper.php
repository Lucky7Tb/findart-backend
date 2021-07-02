<?php

namespace App\Helper;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Helper
{

	public static function saveImage($image, $savePath)
	{
		$newFileName = date('YmdHis').'-'.$image->getClientOriginalName();
		$newFileName = Str::replace(' ', '', $newFileName);

		Storage::putFileAs($savePath, $image, $newFileName);

		$fileUrl = asset('storage/images/'.$newFileName);

		return $fileUrl;
	}

	public static function deleteImage($urlImage)
	{
		$imagePath = Str::remove(env('APP_URL').'/public/storage', $urlImage);

		if (Storage::disk('public')->exists($imagePath)) {
			Storage::disk('public')->delete($imagePath);
		}
	}
}
