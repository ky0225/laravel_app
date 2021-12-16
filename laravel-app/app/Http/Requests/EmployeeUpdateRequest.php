<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeUpdateRequest extends FormRequest
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
			// uniqueのバリデーションで id と email を除外する
			// Rule::unique({テーブル名またはModel})->ignore({チェックする値}, {カラム名})
			'id' => ['required', 'integer', Rule::unique('employees')->ignore($this->id)],
			'email' => ['required', 'string', 'email', Rule::unique('employees')->ignore($this->id)],
			// 外部キー制約があるため、exists:テーブル名, カラム名 とし指定のカラムが存在していることを必須とする
			'organization_id' => ['exists:organizations,id'],
			'base_id' => ['exists:bases,id'],
			'last_name' => ['required', 'string', 'max:10'],
			'first_name' => ['required', 'string', 'max:10'],
		];
	}
}
