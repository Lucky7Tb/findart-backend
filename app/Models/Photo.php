<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Photo extends Model
{
  protected $table = 'photos';

	/**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		self::creating(function ($photo) {
			$photo->created_at = \Carbon\Carbon::now();
			$photo->updated_at = \Carbon\Carbon::now();
		});

		self::updated(function ($photo) {
			$photo->updated_at = \Carbon\Carbon::now();
		});
	}
}
