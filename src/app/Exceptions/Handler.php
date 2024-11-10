<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // メールアドレスの一意制約違反の場合の処理
        if ($exception instanceof QueryException && $exception->errorInfo[1] == 1062) {
            return response()->json([
                'status' => 400,
                'error' => 'Duplicate entry: The email address already exists.'
            ], 400);
        }

        return parent::render($request, $exception);
    }
}
