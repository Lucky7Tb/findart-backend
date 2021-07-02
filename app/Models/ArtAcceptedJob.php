<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ArtAcceptedJob extends Model
{
	protected $table = 'art_accepted_job';

	public function scopeIsMyArt($query, $artFinderId)
	{
		return $query->where('art_finder_id', $artFinderId);
	}

	public function scopeIsAccepted($query)
	{
		return $query->where('job_status', '1');
	}

	public function art()
	{
		return $this->belongsTo(Art::class);
	}

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		self::creating(function ($artAcceptedJob) {
			$artAcceptedJob->created_at = \Carbon\Carbon::now();
			$artAcceptedJob->updated_at = \Carbon\Carbon::now();
		});

		self::updated(function ($artAcceptedJob) {
			$artAcceptedJob->updated_at = \Carbon\Carbon::now();
		});
	}
}
