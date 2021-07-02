<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Art extends Model
{
	protected $table = 'art';

	protected $fillable = ['art_phone_number', 'art_address', 'art_bio', 'photo_id'];

	public function rating()
	{
		return $this->hasMany(ArtRating::class);
	}

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

	public function artRating()
	{
		return $this->rating()
			->selectRaw('art_id, avg(rating) as art_rating')
			->groupBy('art_id');
	}

	protected static function boot()
	{
		parent::boot();

		self::creating(function($art) {
			$art->created_at = \Carbon\Carbon::now();
			$art->updated_at = \Carbon\Carbon::now();
		});

		self::updated(function($art) {
			$art->updated_at = \Carbon\Carbon::now();
		});
	}
}
