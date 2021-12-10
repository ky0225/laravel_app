<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
			'id' => ['required', 'integer', 'unique:employees'],
			// 外部キー制約があるため、exists:テーブル名, カラム名 とし指定のカラムが存在していることを必須とする
			'organization_id' => ['exists:organizations,id'],
			'base_id' => ['exists:bases,id'],
			'last_name' => ['required', 'string', 'max:10'],
			'first_name' => ['required', 'string', 'max:10'],
			'email' => ['required', 'string', 'email', 'unique:employees'],
		];
	}
}
