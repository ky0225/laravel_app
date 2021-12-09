<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Organization;
use App\Models\Base;

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
	public function store(Request $request)
	{
//		$request->validate([
//			'id' => ['required', 'integer', 'unique:id'],
//			// 外部キー制約があるため、exists:テーブル名, カラム名 としいずれも必須であることをルールとする
//			'organization_id' => ['required', 'exists:organizations,id'],
//			'base_id' => ['required', 'exists:bases,id'],
//			'last_name' => ['required', 'string', 'max:10', 'unique:id'],
//			'first_name' => ['required', 'string', 'max:10', 'unique:id'],
//			'email' => ['required', 'string', 'email', 'unique:email'],
//		]);

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
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
