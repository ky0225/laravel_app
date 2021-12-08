<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * The path to the "home" route for your application.
	 *
	 * This is used by Laravel authentication to redirect users after login.
	 *
	 * @var string
	 */
	// 各ユーザーのログイン後のルートを設定
	public const HOME = '/dashboard';
	public const OWNER_HOME = '/owner/dashboard';
	public const ADMIN_HOME = '/admin/dashboard';

	/**
	 * The controller namespace for the application.
	 *
	 * When present, controller route declarations will automatically be prefixed with this namespace.
	 *
	 * @var string|null
	 */
	// protected $namespace = 'App\\Http\\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->configureRateLimiting();

		$this->routes(function () {
			Route::prefix('api')
				->middleware('api')
				->namespace($this->namespace)
				->group(base_path('routes/api.php'));

			// user のルート設定
			Route::prefix('/') // URL の最初の文字列を指定
				->as('user.') // ルートに別名をつける(記述が楽になる）
				->middleware('web') // ユーザーの認証確認
				->namespace($this->namespace) // 名前空間
				->group(base_path('routes/web.php')); // 指定のファイルに全ての設定を適用させる

			// admin のルート設定
			Route::prefix('admin')
				->as('admin.')
				->middleware('web')
				->namespace($this->namespace)
				->group(base_path('routes/admin.php'));

			// user のルート設定
			Route::prefix('owner')
				->as('owner.')
				->middleware('web')
				->namespace($this->namespace)
				->group(base_path('routes/owner.php'));
		});
	}

	/**
	 * Configure the rate limiters for the application.
	 *
	 * @return void
	 */
	protected function configureRateLimiting()
	{
		RateLimiter::for('api', function (Request $request) {
			return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
		});
	}
}
