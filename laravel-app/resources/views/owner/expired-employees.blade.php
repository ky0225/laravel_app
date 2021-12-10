<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			削除済み社員一覧
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="pt-6 md:p-6 bg-white border-b border-gray-200">
					{{--tailblocks --}}
						<section class="text-gray-600 body-font">
							<div class="container md:px-5 mx-auto">
								<x-flash-message status="session('status')"></x-flash-message>
								<div class="lg:w-2/3 w-full mx-auto overflow-auto">
									<table class="table-auto w-full text-left whitespace-no-wrap">
										<thead>
										<tr>
											<th class="ma:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">社員ID</th>
											<th class="ma:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">所属</th>
											<th class="ma:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">拠点</th>
											<th class="ma:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">姓</th>
											<th class="ma:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">名</th>
											<th class="ma:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
											<th class="ma:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">削除した日時</th>
											<th class="ma:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
										</tr>
										</thead>
										<tbody>
											@foreach($expiredEmployees as $expiredEmployee)
											<tr>
												<td class="ma:px-4 py-3">{{ $expiredEmployee->id }}</td>
												<td class="ma:px-4 py-3">{{ $expiredEmployee->organization->name }}</td>
												<td class="ma:px-4 py-3">{{ $expiredEmployee->base->name }}</td>
												<td class="ma:px-4 py-3">{{ $expiredEmployee->last_name }}</td>
												<td class="ma:px-4 py-3">{{ $expiredEmployee->first_name }}</td>
												<td class="ma:px-4 py-3">{{ $expiredEmployee->email }}</td>
												<td class="ma:px-4 py-3">{{ $expiredEmployee->deleted_at }}</td>
												<form id="delete_{{ $expiredEmployee->id }}" method="post" action="{{ route('owner.expired-employees.destroy', ['employee' => $expiredEmployee->id]) }}">
													{{-- ルーティングでdestroyをPOST通信するよう記述しているため、@method="delete" の記述は不要（エラー発生） --}}
													@csrf
													<td class="ma:px-4 py-3">
														<a href="#" data-id="{{ $expiredEmployee->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">完全に削除</a>
													</td>
												</form>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</section>
				</div>
			</div>
		</div>
	</div>
	<script>
		function deletePost(e) {
			'use strict';
			if (confirm('本当に削除してもいいですか？')) {
				document.getElementById('delete_' + e.dataset.id).submit();
			}
		}
	</script>
</x-app-layout>
