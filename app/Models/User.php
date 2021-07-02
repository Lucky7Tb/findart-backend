<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use HasApiTokens;

	protected $fillable = [
		'username',
		'password',
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
	];

	public function getRoleAttribute()
	{
		return $this->attributes['role'] === 1 ? 'Art' : 'Finder';
	}

	public function setPasswordAttribute($value)
	{
		$this->attributes['password'] = Hash::make($value);
	}

	protected static function boot()
	{
		parent::boot();

		self::creating(function ($user) {
			$user->created_at = \Carbon\Carbon::now();
			$user->updated_at = \Carbon\Carbon::now();
		});

		self::updated(function ($user) {
			$user->updated_at = \Carbon\Carbon::now();
		});
	}
}
