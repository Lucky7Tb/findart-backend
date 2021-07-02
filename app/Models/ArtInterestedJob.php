<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ArtInterestedJob extends Model
{
 	protected $table = 'art_interested_job';

	protected $fillable = ['apply_status'];

 	public function scopePendingStatus($query)
 	{
 		return $query->where('job_status', 0);
 	}

 	public function art()
 	{
 		return $this->belongsTo(Art::class);
 	}

	public function jobVacancy()
	{
		return $this->belongsTo(JobVacancy::class);
	}

	protected static function boot()
	{
		parent::boot();

		self::creating(function ($artInterestedJob) {
			$artInterestedJob->created_at = \Carbon\Carbon::now();
			$artInterestedJob->updated_at = \Carbon\Carbon::now();
		});;

		self::updated(function ($artInterestedJob) {
			$artInterestedJob->updated_at = \Carbon\Carbon::now();
		});
	}
}
