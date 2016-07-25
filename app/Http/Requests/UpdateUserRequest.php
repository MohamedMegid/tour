<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request {

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
			'name' => 'required|min:5|max:255|unique:users,name,'.$this->get('id'),
			'email' => 'required|email|max:255|unique:users,email,'.$this->get('id'),
			'password' => 'confirmed|min:6|max:20',
			'phone' => 'required|max:255|unique:users,phone,'.$this->get('id'),
		];
	}

}