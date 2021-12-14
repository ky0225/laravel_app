{{--<form action="" method="get" enctype="multipart/form-data">--}}
{{--	{{ csrf_field() }}--}}
{{--	<div class="row">--}}
{{--		<label class="col-1 text-right" for="form-file-1">File:</label>--}}
{{--		<div class="col-11">--}}
{{--			<div class="custom-file">--}}
{{--				<input type="file" name="csv" class="custom-file-input" id="customFile">--}}
{{--				<label class="custom-file-label" for="customFile" data-browse="参照"></label>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}
{{--	<button type="submit" class="btn btn-success btn-block">送信</button>--}}
{{--</form>--}}

	<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CSVからDBインポートサンプル</title>
</head>

<body>

<div class="upload">
	<p>DBに追加したいCSVデータを選択してください。</p>
	<form action="/owner/csv/upload/" method="post" enctype="multipart/form-data">
		@csrf
		<input type="file" name="csvdata" />

		<label for="customFile" class="custom-file-label" data-browse="参照"></label>
		<input type="file" id="customFile" name="csv" class="custom-file-input">

		<button>送信</button>
	</form>
</div>

<div class="contents">
	<p>{{ $cnt }}件登録しました。</p>
	<table>
		<tr>
			<th>社員ID</th>
			<th>所属</th>
			<th>拠点</th>
			<th>姓</th>
			<th>名</th>
			<th>メールアドレス</th>
			<th>created_at</th>
			<th>updated_at</th>
		</tr>

		<!-- DBから取得したデータを一覧表示する -->
		@foreach ($data as $val)
			<tr>
				<td>{{ $val->id }}</td>
				<td>{{ $val->organization_id }}</td>
				<td>{{ $val->base_id }}</td>
				<td>{{ $val->last_name }}</td>
				<td>{{ $val->first_name }}</td>
				<td>{{ $val->email }}</td>
				<td>{{ $val->created_at }}</td>
				<td>{{ $val->updated_at }}</td>
			</tr>
		@endforeach
	</table>
</div>

</body>
</html>
