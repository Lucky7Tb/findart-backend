<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;
use App\Models\ArtFinder;

class JobVacancy extends Model
{
	protected $table = 'job_vacancy';

	protected $casts = [
		'updated_at' => 'datetime',
		'created_at' => 'datetime'
	];

	public function scopeMyJobVacancy($query)
	{
		$artFinder = ArtFinder::select('id')->where('user_id', auth()->user()->id)->first();

		return $query->where('art_finder_id', $artFinder['id']);
	}

 	public function scopeVisibleJobVacancy($query)
  {
		return $query->where('is_visible', 1);
  }

	public function scopeStillAvailable($query)
	{
		return $query->where('job_due_date', '>=', \Carbon\Carbon::today());
	}

	public function artFinder()
	{
		return $this->belongsTo(ArtFinder::class);
	}

	public function photo()
	{
		return $this->belongsTo(Photo::class);
	}

  protected static function boot()
	{
		parent::boot();

		self::creating(function ($jobVacancy) {
			$jobVacancy->created_at = \Carbon\Carbon::now();
			$jobVacancy->updated_at = \Carbon\Carbon::now();
		});

		self::updated(function ($jobVacancy) {
			$jobVacancy->updated_at = \Carbon\Carbon::now();
		});
	}
}
