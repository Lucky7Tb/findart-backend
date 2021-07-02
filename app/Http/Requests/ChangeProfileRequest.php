<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeProfileRequest extends FormRequest
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
			'address' => 'required',
			'phone_number' => 'required|digits_between:10,15|regex:/[0-9]/|unique:art,art_phone_number,'.auth()->user()->id.',user_id|unique:art_finder,art_finder_phone_number,' . auth()->user()->id .',user_id',
		];
	}
}
