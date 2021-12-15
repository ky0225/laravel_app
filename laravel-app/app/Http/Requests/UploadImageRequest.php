<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	// 認証されているユーザーが使えるかどうか（基本的には true）
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	// バリデーションルール（今回は拡張子と容量）
	public function rules()
	{
		return [
			'image' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
			'files.*.image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
		];
	}

	// エラーメッセージ
	public function messages()
	{
		return [
			'image' => '指定されたファイルが画像ではありません。',
			'mimes' => '指定された拡張子（jpg/jpeg/png）ではありません。',
			'max' => 'ファイルサイズは2MB以内にしてください。',
		];
	}
}
