<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyRequest extends FormRequest
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
			$rules = [
    		'job_thumbnail' => 'image|mimes:jpg,jpeg,png|max:2048',
        'job_description' => 'required',
        'job_payment' => 'required|integer|min:2000000',
        'job_due_date' => 'required|date'
    	];

    	if ($this->getMethod() == 'POST') {
    		$rules['job_thumbnail'] = 'required|'.$rules['job_thumbnail'];
    	}

      return $rules;
    }
}
