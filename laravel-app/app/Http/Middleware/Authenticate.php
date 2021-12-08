<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
//use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
	// プロパティ
	protected $user_route = 'user.login';
	protected $owner_route = 'owner.login';
	protected $admin_route = 'admin.login';

	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return string|null
	 */
	protected function redirectTo($request)
	{
		if (!$request->expectsJson()) {
			// ユーザー認証ができていないとき、ログイン画面にリダイレクト処理
			if (Route::is('user.*')) {
				return route($this->user_route);
			}
			if (Route::is('owner.*')) {
				return route($this->owner_route);
			}
			if (Route::is('admin.*')) {
				return route($this->admin_route);
			}
		}
	}
}
