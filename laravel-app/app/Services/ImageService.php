<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ImageService
{
	// static によって :: で呼び出せるようにする
	public static function upload($imageFile, $folderName)
	{
		// ランダムなファイル名を生成
		$fileName = uniqid(rand() . '_');
		// 拡張子を取得
		$extension = $imageFile->extension();
		// ファイル名と拡張子を足して、正規のファイル名を作成
		$fileNameToImage = $fileName . '.' . $extension;
		// InterventionImage によってリサイズ、エンコード
		$resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();

		// 第1引数にフォルダ名とファイル名、 第2引数に指定の画像
		Storage::put('public/' . $folderName . '/' . $fileNameToImage, $resizedImage);

		return $fileNameToImage;
	}

}
