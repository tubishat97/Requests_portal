<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {

            if ($exception instanceof ValidationException) {
                return response()->json([
                    'status' => 'failed',
                    'message' => trans('api.auth.validation_error'),
                    'code' => 400,
                    'errors' => $exception->validator->errors()
                ], 200);
            }

            if ($request->expectsJson()) {

                if (get_class($exception) == 'Illuminate\Database\Eloquent\ModelNotFoundException') {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Model not found',
                        'code' => 400,
                    ], 400);
                }

                if ($exception instanceof AuthenticationException) {
                    return $this->unauthenticated($request, $exception);
                }

                if ($exception instanceof AuthorizationException) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => $exception->getMessage(),
                        'code' => 403,
                    ], 403);
                }

                if ($exception instanceof NotFoundHttpException) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => trans('api.auth.invalid_route'),
                        'code' => 404,
                    ], 404);
                }

                if ($exception instanceof MethodNotAllowedHttpException) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => trans('api.auth.method_invalid'),
                        'code' => 404,
                    ], 404);
                }

                if ($exception instanceof HttpException) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => $exception->getMessage(),
                        'code' => $exception->getStatusCode(),
                    ], $exception->getStatusCode());
                }

                if ($exception instanceof QueryException) {
                    $errorCode = $exception->errorInfo[1];
                    if ($errorCode == 1451) {
                        return response()->json([
                            'status' => 'failed',
                            'message' => trans('api.auth.related_resource'),
                            'code' => 409,
                        ], 409);
                    }
                }
            }
            if (!empty($exception->getMessage())) {
                return response()->json([
                    'status' => 'failed',
                    'message' => $exception->getMessage(),
                    'code' => 400,
                ]);
            }
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'failed',
                'message' => trans('api.auth.unauthinicated'),
                'code' => 401
            ], 401);
        }

        return redirect()->guest(route('login'));
    }
}
