<form action="" method="get" enctype="multipart/form-data">
	{{ csrf_field() }}
	<div class="row">
		<label class="col-1 text-right" for="form-file-1">File:</label>
		<div class="col-11">
			<div class="custom-file">
				<input type="file" name="csv" class="custom-file-input" id="customFile">
				<label class="custom-file-label" for="customFile" data-browse="参照"></label>
			</div>
		</div>
	</div>
	<button type="submit" class="btn btn-success btn-block">送信</button>
</form>
