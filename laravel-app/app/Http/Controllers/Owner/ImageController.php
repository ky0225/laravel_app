<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Http\Requests\UploadImageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	// コントローラーでもユーザー認証を設定する
	public function __construct()
	{
		$this->middleware('auth:owners');
	}

	function show(){
		return view("owner.images.upload_form");
	}

	function upload(Request $request){
		$request->validate([
			// viewファイル内の type="file" name="image" と同じ値
			'filename' => ['file', 'image', 'mimes:png,jpeg'],
		]);

		$uploadImage = $request->file('image');

		if ($uploadImage) {
			// アップロードされた画像を保存
			$path = $uploadImage->store('uploads', 'public');
			// 保存に成功したらDBに記録
			if ($path) {
				Image::create([
					'filename' => $uploadImage->getClientOriginalName(),
					'filepath' => $path,
				]);
			}
		}
		return redirect()->route('owner.images.form');
	}

}
