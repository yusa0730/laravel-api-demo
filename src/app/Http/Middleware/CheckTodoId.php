<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTodoId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $todoId = $request->route('todoId');

        if (!$todoId || !is_numeric($todoId)) {
            return response()->json([
                'status' => 400,
                'message' => 'Bad Request: todoId is required'
            ], 400);
        }
        return $next($request);
    }
}
