<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userId = $request->route('userId');

        if (!$userId || !is_numeric($userId)) {
            return response()->json([
                'status' => 400,
                'message' => 'Bad Request: userId is required'
            ], 400);
        }

        // リクエストパラメーターのuserIdの値が認証されたログインしているユーザーのidの値と同じかどうかを確認
        if ($userId != Auth::id()) {
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden: Unauthorized action'
            ], 403);
        }

        // 条件を満たす場合、次の処理に進む
        return $next($request);
    }
}
