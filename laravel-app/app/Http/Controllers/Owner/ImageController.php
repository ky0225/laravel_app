<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Http\Requests\UploadImageRequest;

class ImageController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __construct()
	{
		$this->middleware('auth:owners');
	}

	public function index()
	{
		$images = Image::select('id', 'filename', 'title')
			->orderBy('updated_at', 'desc')
			->get();

		return view('owner.images.index', compact('images'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function create()
	{
		return view('owner.images.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(UploadImageRequest $request)
	{
		$imageFiles = $request->file('files');
		if (!is_null($imageFiles)){
			foreach ($imageFiles as $imageFile) {
				$fileNameToImage = ImageService::upload($imageFile, 'images');
				Image::create([
					'filename' => $fileNameToImage,
				]);
			}
		}
		return redirect()
			->route('owner.images.index')
			->with([
				'message' => '画像の登録が完了しました。',
				'status' => 'info',
			]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$image = Image::findOrFail($id);
		return view('owner.images.edit', compact('image'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, $id)
	{
		$request->validate([
			'title' => ['string', 'max:50'],
		]);

		$image = Image::findOrFail($id);
		$image->title = $request->title;
		$image->save();

		return redirect()
			->route('owner.images.index')
			->with([
				'message' => '画像情報が更新されました。',
				'status' => 'info',
			]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
