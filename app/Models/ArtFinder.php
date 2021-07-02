<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtFinder extends Model
{
	protected $table = 'art_finder';

	protected $fillable = ['art_finder_phone_number', 'art_finder_address', 'photo_id'];

	public function photo()
	{
		return $this->belongsTo(Photo::class);
	}

	public function province()
	{
		return $this->belongsTo(Province::class);
	}

	public function city()
	{
		return $this->belongsTo(City::class);
	}

	public function district()
	{
		return $this->belongsTo(District::class);
	}

	public function subDistrict()
	{
		return $this->belongsTo(SubDistrict::class);
	}

	protected static function boot()
	{
		parent::boot();

		self::creating(function ($artFinder) {
			$artFinder->created_at = \Carbon\Carbon::now();
			$artFinder->updated_at = \Carbon\Carbon::now();
		});

		self::updated(function ($artFinder) {
			$artFinder->updated_at = \Carbon\Carbon::now();
		});
	}
}
