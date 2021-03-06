<x-app-layout>
	<x-slot name="header">
			<h2 class="font-semibold mb-4 text-xl text-gray-800 leading-tight">
				社員名簿
			</h2>
		  <div class="flex justify-between items-center">
				<form method="get" action="{{ route('owner.employees.index') }}">
					<div class="flex">
						<div class="lg:flex items-center">
							<div class="mb-4">
								所属で検索：
								<select name="organization" class="mb-2 lg:mb-0">
									<option value="0"
									@if(\Request::get('organization') === '0') selected
									@endif> 全て
									</option>
									@foreach($organizations as $organization)
										<option value="{{ $organization->id }}"
										@if(\Request::get('organization') == $organization->id) selected
										@endif> {{ $organization->name }}
										</option>
									@endforeach
								</select>
							</div>

							<div class="mb-4">
								拠点で検索：
								<select name="base" class="mb-2 lg:mb-0">
									<option value="0"
													@if(\Request::get('base') === '0') selected
										@endif> 全て
									</option>
									@foreach($bases as $base)
										<option value="{{ $base->id }}"
														@if(\Request::get('base') == $base->id) selected
											@endif> {{ $base->name }}
										</option>
									@endforeach
								</select>
							</div>

								<div class="flex space-x-2 items-center">
									<div class="flex">
										<input name="keyword" class="border text-gray-1000 py-2 px-2" placeholder="キーワード入力">
									</div>
									<div>
										<button class="text-white bg-indigo-500 border-0 mr-4 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">検索</button>
									</div>
									<div>
										<span class="text-sm">表示順</span><br>
										<select id="sort" name="sort" class="mr-4">
											<option value="{{ \Constant::SORT_ID['older']}}"
															@if(\Request::get('sort') === \Constant::SORT_ID['older'] )
															selected
												@endif>ID昇順
											</option>
											<option value="{{ \Constant::SORT_ID['later']}}"
															@if(\Request::get('sort') === \Constant::SORT_ID['later'] )
															selected
												@endif>ID降順
											</option>
										</select>
									</div>
								</div>
						</div>
					</div>

				</form>
			</div>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="md:p-6 bg-white border-b border-gray-200">
					{{--tailblocks --}}
					<section class="text-gray-600 body-font">
						<div class="container md:px-5 mx-auto">
							<x-flash-message status="session('status')"></x-flash-message>
							<div class="flex justify-end mb-4 mt-4">
								<button onclick="location.href='{{ route('owner.employees.create') }}'" class="text-white bg-indigo-500 border-0 mr-4 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">新規登録する</button>
								<button onclick="location.href='{{ route('owner.csv.index') }}'" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-md">CSVファイルで一括登録する</button>
							</div>
							<div class="lg:w-2/3 w-full mx-auto overflow-auto">
								<table class="table-auto w-full text-left whitespace-no-wrap">
									<thead>
									<tr>
										<th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">社員ID</th>
										<th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">所属</th>
										<th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">拠点</th>
										<th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">姓</th>
										<th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">名</th>
										<th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
										<th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
										<th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
									</tr>
									</thead>
									<tbody>
									@foreach($employees as $employee)
										<tr>
											<td class="md:px-4 py-3">{{ $employee->id }}</td>
											<td class="md:px-4 py-3">{{ $employee->organization->name }}</td>
											<td class="md:px-4 py-3">{{ $employee->base->name }}</td>
											<td class="md:px-4 py-3">{{ $employee->last_name }}</td>
											<td class="md:px-4 py-3">{{ $employee->first_name }}</td>
											<td class="md:px-4 py-3">{{ $employee->email }}</td>
											<td class="md:px-4 py-3">
												<button onclick="location.href='{{ route('owner.employees.edit', ['employee' => $employee->id]) }}'" class="text-white bg-indigo-400 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-500 rounded">編集</button>
											</td>
											<form id="delete_{{ $employee->id }}" method="post" action="{{ route('owner.employees.destroy', ['employee' => $employee->id]) }}">
												@method("delete")
												@csrf
												<td class="px-4 py-3">
													<a href="#" data-id="{{ $employee->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">削除</a>
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
		// 削除の確認ダイアログ
		function deletePost(e) {
			'use strict';
			if (confirm('本当に削除してもいいですか？')) {
				document.getElementById('delete_' + e.dataset.id).submit();
			}
		}

		// 表示切り替えの処理
		const select = document.getElementById('sort');
		select.addEventListener('change', function(){
			this.form.submit();
		});
	</script>
</x-app-layout>
