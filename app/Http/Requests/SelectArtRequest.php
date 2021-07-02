<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelectArtRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'art_id' => 'required|integer',
			'job_vacancy_id' => 'required|integer'
		];
	}
}
