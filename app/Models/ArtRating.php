<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ArtRating extends Model
{
  protected $table = 'art_rating';

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		self::creating(function ($artRating) {
			$artRating->created_at = \Carbon\Carbon::now();
			$artRating->updated_at = \Carbon\Carbon::now();
		});
	}
}
