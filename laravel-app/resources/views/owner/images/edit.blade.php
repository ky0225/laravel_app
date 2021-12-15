<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			画像編集
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
								<x-auth-validation-errors class="mb-4" :errors="$errors" />
								{{--画像データ保存のためには enctype="multipart/form-data" の記述が必要--}}
								<form method="post" action="{{ route('owner.images.update', ['image' => $image->id]) }}" enctype="multipart/form-data">
									@csrf
									@method('put')
									<div class="-m-2">
										<div class="p-2 w-2/3 mx-auto">
											<div class="relative">
												<label for="title" class="leading-7 text-sm text-gray-600">画像タイトル</label>
												{{--multiple で複数のデータを触れるように。 name="files[][image]" で複数のデータを配列で受け取りバリデーションに流せる--}}
												<input type="text" id="title" name="title" value="{{ $image->title }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
											</div>
										</div>
										<div class="p-2 w-2/3 mx-auto">
											<div class="relative">
												<x-thumbnail :filename="$image->filename"></x-thumbnail>
											</div>
										</div>
										<div class="p-2 w-full flex justify-around mt-4">
											<button type="button" onclick="location.href='{{ route('owner.images.index') }}'" class="text-white bg-gray-400 border-0 py-2 px-8 focus:outline-none hover:bg-gray-500 rounded text-lg">戻る</button>
											<button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新する</button>
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
</x-app-layout>
