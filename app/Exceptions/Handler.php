<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e, $request) {
            if ($e instanceof AuthenticationException) {
                return $this->unauthenticated($request, $e);
            } elseif ($e instanceof AccessDeniedHttpException) {
                return response()->json(['message' => $e->getMessage()], 403);
            } elseif ($e instanceof ValidationException) {
                return $this->convertValidationExceptionToResponse($e, $request);
            } elseif ($e instanceof MethodNotAllowedHttpException) {
                return response()->json(['message' => $e->getMessage(), 405]);
            }

            return $this->errorResponse("Unexpected Exception. Try later", 500);
        });
    }

    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($this->isFrontend($request)) {
            return $request->ajax() ? $e->response : back()->withInput($request->input())->withErrors($e->errors());
        }

        return $this->invalidJson($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($this->isFrontend($request)) {
            return redirect()->guest($exception->redirectTo() ?? route('login'));
        }

        return response()->json(['message' => $exception->getMessage()], 401);
    }

    protected function isFrontend($request)
    {
        return $request->acceptsHtml() && collect($request->route()->middleware())->contains('web');
    }
}
