<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 leading-tight">
			社員名簿
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="md:p-6 bg-white border-b border-gray-200">
					{{--tailblocks --}}
					<section class="text-gray-600 body-font">
						<div class="container md:px-5 mx-auto">
							<x-flash-message status="session('status')"></x-flash-message>
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
</x-app-layout>
