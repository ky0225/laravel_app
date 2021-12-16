<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			社員登録
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 bg-white border-b border-gray-200">
					{{--tailblocks--}}
					<section class="text-gray-600 body-font relative">
						<div class="container px-5 mx-auto">
							<div class="lg:w-1/2 md:w-2/3 mx-auto">
								{{--バリデーションによるエラー文の表示をregisterファイルの記述からコピー--}}
								<x-auth-validation-errors class="mb-4" :errors="$errors"></x-auth-validation-errors>
								<form method="post" action="{{ route('owner.employees.store') }}">
									@csrf
									<div class="-m-2">
										<div class="p-2 w-1/2 mx-auto">
											<div class="relative">
												<label for="id" class="leading-7 text-sm text-gray-600">社員ID</label>
												<input type="text" id="id" name="id" value="{{ old('id') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
											</div>
										</div>
										<div class="p-2 w-1/2 mx-auto">
											<div class="relative">
												<label for="id" class="leading-7 text-sm text-gray-600">所属</label>
												<br>
												<select name="organization">
													@foreach($organizations as $organization)
														<option value="{{ $organization->id }}">
															{{ $organization->name }}
														</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="p-2 w-1/2 mx-auto">
											<div class="relative">
												<label for="id" class="leading-7 text-sm text-gray-600">拠点</label>
												<br>
												<select name="base">
													@foreach($bases as $base)
														<option value="{{ $base->id }}">
															{{ $base->name }}
														</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="p-2 w-1/2 mx-auto">
											<div class="relative">
												<label for="last_name" class="leading-7 text-sm text-gray-600">姓</label>
												<input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
											</div>
										</div>
										<div class="p-2 w-1/2 mx-auto">
											<div class="relative">
												<label for="first_name" class="leading-7 text-sm text-gray-600">名</label>
												<input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
											</div>
										</div>
										<div class="p-2 w-1/2 mx-auto">
											<div class="relative">
												<label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
												<input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
											</div>
										</div>
										<x-select-image :images="$images" name="image1"></x-select-image>
										<div class="p-2 w-full flex justify-around mt-4">
											<button type="button" onclick="location.href='{{ route('owner.employees.index') }}'" class="text-white bg-gray-400 border-0 py-2 px-8 focus:outline-none hover:bg-gray-500 rounded text-lg">戻る</button>
											<button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</section>

				</div>
			</div>
		</div>
	</div>
	<script>
		'use strict';
		const images = document.querySelectorAll('.image'); //全てのimageタグを取得
		images.forEach(image => { // 1つずつ繰り返す
			image.addEventListener('click', function(e){ // クリックしたら
				const imageName = e.target.dataset.id.substr(0, 6); //data-idの6文字
				const imageId = e.target.dataset.id.replace(imageName + '_', ''); // 6文字カット
				const imageFile = e.target.dataset.file;
				const imagePath = e.target.dataset.path;
				const modal = e.target.dataset.modal;
				// サムネイルと input type=hiddenのvalueに設定
				document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile;
				document.getElementById(imageName + '_hidden').value = imageId;
				MicroModal.close(modal); //モーダルを閉じる
			})
		})
	</script>
</x-app-layout>
