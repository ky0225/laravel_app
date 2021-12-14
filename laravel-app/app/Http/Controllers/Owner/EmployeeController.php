<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\Base;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class EmployeeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function __construct()
	{
		$this->middleware('auth:owners');
	}

	public function index()
	{
		$employees = Employee::select('id', 'organization_id', 'base_id', 'last_name', 'first_name', 'email')
			->orderBy('id', 'asc')->paginate(50);

		return view('owner.employees.index', compact('employees'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function create()
	{
		$organizations = Organization::select('id', 'name')->get();
		$bases = Base::select('id', 'name')->get();

		return view('owner.employees.create', compact('organizations', 'bases'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(EmployeeStoreRequest $request)
	{
		Employee::create([
			'id' => $request->id,
			'organization_id' => $request->organization,
			'base_id' => $request->base,
			'last_name' => $request->last_name,
			'first_name' => $request->first_name,
			'email' => $request->email,
		]);

		return redirect()
			->route('owner.employees.index')
			->with([
				'message' => '社員名簿への登録が完了しました。',
				'status' => 'info',
				]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$employee = Employee::findOrFail($id);
		$organizations = Organization::select('id', 'name')->get();
		$bases = Base::select('id', 'name')->get();

		return view('owner.employees.edit', compact('employee', 'organizations', 'bases'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(EmployeeUpdateRequest $request, $id)
	{
		$employee = Employee::findOrFail($id);
		$employee->id = $request->id;
		$employee->organization_id = $request->organization;
		$employee->base_id = $request->base;
		$employee->last_name = $request->last_name;
		$employee->first_name = $request->first_name;
		$employee->email = $request->email;
		$employee->save();

		return redirect()
			->route('owner.employees.index')
			->with([
				'message' => '社員情報の更新が完了しました。',
				'status' => 'info',
			]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy($id)
	{
		Employee::findOrFail($id)->delete(); // ソフトデリート

		return redirect()
			->route('owner.employees.index')
			->with([
				'message' => '名簿から削除しました',
				'status' => 'alert',
			]);
	}

	// ソフトデリートされた一覧の表示
	public function expiredEmployeeIndex()
	{
		$expiredEmployees = Employee::onlyTrashed()->get();

		return view('owner.expired-employees', compact('expiredEmployees'));
	}

  // 完全削除するための処理
	public function expiredEmployeeDestroy($id)
	{
		Employee::onlyTrashed()->findOrFail($id)->forceDelete();

		return redirect()
			->route('owner.expired-employees.index')
			->with([
				'message' => '名簿から完全に削除しました',
				'status' => 'alert',
			]);
	}

	// CSV一覧表示処理
	public function csvIndex(Request $request)
	{
		$data = Employee::select('id', 'organizatEion_id', 'base_id', 'last_name', 'first_name', 'email')->get();
		$count = $request->input('count'); // 何件登録したか結果を返す

		return view('owner.csv', compact('data', 'count'));
	}

	// CSVアップロード〜DBインポート処理
	public function csvUpload(Request $request)
	{
		// 一旦アップロードされたCSVファイルを受け取り保存する
		$uploadFile = $request->file('csvdata'); // inputのnameはcsvdataとする
		$orgName = date('YmdHis') . "_" . $request->file('csvdata')->getClientOriginalName();
		$spath = storage_path('app\\');
		$path = $spath.$request->file('csvdata')->storeAs('', $orgName);

		// CSVファイルを読み込む
		$result = (new FastExcel)->configureCsv(',')->importSheets($path);

		// DB登録処理
		$count = 0; // 登録件数確認用
		foreach ($result as $row) {
			foreach ($row as $item) {
				// CSV内データとテーブルのカラムを紐付ける（左側カラム名、右側CSV１行目の項目名）
				$param = [
					'id' => '"' . $item->id . '"',
					'organization_id' => '"' . $item->organization_id . '"',
					'base_id' => '"' . $item->base_id . '"',
					'last_name' => '"' . $item->last_name . '"',
					'first_name' => '"' . $item->first_name . '"',
					'email' => '"' . $item->email . '"',
				];
				// DBにinsertする（更新フラグなどに対応するため１行ずつinsertする）
				DB::table('employees')->insert($param);
				$count++;
			}
		}
		return redirect()->route('owner.csv.index', compact('count'));
	}

}
