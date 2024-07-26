<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        /* Handle all api invalid response as Invalid Operation */

        $this->renderable(function (Exception $e, $request) {

            if ($request->is('api/*') || request()->expectsJson()) {

                return response()->json([

                    'message' => 'Invalid Operation'

                ], 404);
            }

            throw $e;

        });
    }
}
