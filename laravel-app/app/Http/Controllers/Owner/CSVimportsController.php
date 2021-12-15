<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use SplFileObject;

class CSVimportsController extends Controller
{

	protected $csvImport = null;

	public function __construct(Employee $csvImport)
	{
		$this->csvImport = $csvImport;
	}

	public function index()
	{
		return view('owner.csv.index');
	}

	/**
	 * CSVインポート
	 *
	 * @param Request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
	 */

	public function import(Request $request)
	{
		// 全件削除
		Employee::truncate();

		// ロケールを設定(日本語に設定)
		setlocale(LC_ALL, 'ja_JP.UTF-8');

		// アップロードしたファイルを取得
		// 'csv_file' はビューの inputタグのname属性
		$uploaded_file = $request->file('csv_file');

		// アップロードしたファイルの絶対パスを取得
		$file_path = $request->file('csv_file')->path($uploaded_file);

		//SplFileObjectを生成
		$file = new SplFileObject($file_path);

		//SplFileObject::READ_CSV が最速らしい
		$file->setFlags(SplFileObject::READ_CSV);

		//配列の箱を用意
		$array = [];

		$row_count = 1;

		//取得したオブジェクトを読み込み
		foreach ($file as $row) {
			// 最終行の処理(最終行が空っぽの場合の対策
			if ($row === [null]) continue;

			// 1行目のヘッダーは取り込まない
			if ($row_count > 1) {
				// CSVの文字コードがSJISなのでUTF-8に変更
				$id = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
				$organization_id = mb_convert_encoding($row[1], 'UTF-8', 'SJIS');
				$base_id = mb_convert_encoding($row[2], 'UTF-8', 'SJIS');
				$last_name = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');
				$first_name = mb_convert_encoding($row[4], 'UTF-8', 'SJIS');
				$email = mb_convert_encoding($row[5], 'UTF-8', 'SJIS');

				$csvImport_array = [
					'id' => $id,
					'organization_id' => $organization_id,
					'base_id' => $base_id,
					'last_name' => $last_name,
					'first_name' => $first_name,
					'email' => $email,
				];

				// つくった配列の箱($array)に追加
				array_push($array, $csvImport_array);

				// 数が多いと処理重すぎなのでバルクインサートに切り替える
				// CSVimport::insert(array(
				//     'name' => $name,
				//     'reserved_date' => $reserved_date,
				//     'checkin_date' => $checkin_date,
				//     'total_price' => $total_price
				// ));
			}
			$row_count++;
		}

		//追加した配列の数を数える
		$array_count = count($array);

		//もし配列の数が500未満なら
		if ($array_count < 500) {
			//配列をまるっとインポート(バルクインサート)
			Employee::insert($array);
		} else {
			//追加した配列が500以上なら、array_chunkで500ずつ分割する
			$array_partial = array_chunk($array, 500); //配列分割
			//分割した数を数えて
			$array_partial_count = count($array_partial); //配列の数
			//分割した数の分だけインポートを繰り替えす
			for ($i = 0; $i <= $array_partial_count - 1; $i++) {
				Employee::insert($array_partial[$i]);
			}
		}

		return redirect()
			->route('owner.employees.index')
			->with([
				'message' => 'ファイルのアップロードが完了しました。',
				'status' => 'info',
			]);
	}

}
