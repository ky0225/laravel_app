<div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
	<div class="modal__overlay" tabindex="-1" data-micromodal-close>
		<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
			<header class="modal__header">
				<h2 class="text-xl text-gray-700" id="modal-1-title">
					ファイルを選択
				</h2>
				<button type="button" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
			</header>
			<main class="modal__content" id="modal-1-content">
				<div class="flex flex-wrap">
					@foreach($images as $image)
						<div class="w-1/4 p-4">
							<div class="border rounded-md p-4">
								{{ $image->title }}
								<img class="image" data-id="image1_{{ $image->id }}" data-file="{{ $image->filename }}"
										 data-path="{{ asset('storage/images/') }}" data-modal="modal-1"
										 src="{{ asset('storage/images/' . $image->filename)}}" >
							</div>
						</div>
					@endforeach
				</div>
			</main>
			<footer class="modal__footer">
				<button type="button" class="modal__btn" data-micromodal-close aria-label="閉じる">閉じる</button>
			</footer>
		</div>
	</div>
</div>

<div class="flex justify-around items-center mb-4">
	<a class="py-2 bg-gray-200" data-micromodal-trigger="modal-1" href='javascript:'>ファイルを選択</a>
	<div class="w-1/4">
		<img id="image1_thumbnail" src=""> </div>
</div>
<input id="image1_hidden" type="hidden" name="image1" value="">
