<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
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

	public function expiredEmployeeIndex()
	{
		$expiredEmployees = Employee::onlyTrashed()->get();

		return view('owner.expired-employees.index', compact('expiredEmployees'));
	}

	public function expiredEmployeeDestroy()
	{

	}

}
