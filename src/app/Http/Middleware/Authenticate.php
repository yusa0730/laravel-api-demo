<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Exceptions\CustomException;

class Authenticate extends Middleware
{
	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 */
	protected function redirectTo(Request $request): ?string
	{
		if (!$request->expectsJson()) {
			return route('login');
		}
	}

	public function handle($request, \Closure $next, ...$guards) {
		// リクエストヘッダーからトークンを取得
		$authHeader = $request->header('Authorization');
		if (!$authHeader || !Str::startsWith($authHeader, 'Bearer ')) {
			throw new CustomException('UnAuthorized', ['No access token provided'], 401);
		}

		$token = Str::after($authHeader, 'Bearer ');

		// データベースからトークンを検索
		$tokenRecord = DB::table('personal_access_tokens')->where('token', hash('sha256', $token))->first();

		if (!$tokenRecord) {
			throw new CustomException('UnAuthorized', ['Token not found in database'], 401);
		}

		// トークンのユーザーIDに基づいてユーザーを取得
		$user = User::find($tokenRecord->tokenable_id);

		if (!$user) {
			throw new CustomException('UnAuthorized', ['User not found'], 401);
		}

		return parent::handle($request, $next, ...$guards);
	}
}
