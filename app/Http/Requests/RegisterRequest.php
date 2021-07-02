<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
			'role' => 'required|numeric|digits_between:0,1',
			'full_name' => 'required',
			'phone_number' => 'required|digits_between:10,15|regex:/[0-9]/|unique:art,art_phone_number|unique:art_finder,art_finder_phone_number',
			'address' => 'required',
			'province_id' => 'required|numeric',
			'city_id' => 'required|numeric',
			'district_id' => 'required|numeric',
			'sub_district_id' => 'required|numeric',
			'username' => 'required|unique:users,username',
			'password' => 'required|min:8',
			'confirm_password' => 'required|same:password'
		];
	}
}
