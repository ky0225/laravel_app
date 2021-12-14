<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
</head>
<body>
<div class="container">
	<div class="content">
		<h4>CSVファイルを選択してください</h4>
		<div class="row">
			<div class="col-md-6">
				■手順<br>
				1. CSVで保存します。<br>
				2. ファイルを選択し読み込んでください。<br>
			</div>
		</div>

		<form role="form" method="post" action="/owner/csv/import" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="file" name="csv_file" id="csv_file">
			<div class="form-group">
				<button type="button" onclick="location.href='{{ route('owner.employees.index') }}'">一覧に戻る</button>
				<button type="submit" class="btn btn-default btn-success">保存</button>
			</div>
		</form>

	</div>
</div>
</body>
</html>
