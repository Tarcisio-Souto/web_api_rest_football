<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        
    }

    public function render($request, Throwable $e)
    {

        if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            if ($request->expectsJson())
                return response()->json(['error' => 'Pagina nao encontrada.', $e->getStatusCode()]);
        }

        if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            if ($request->expectsJson())
                return response()->json(['error' => 'Esta rota nao suporta este metodo.', $e->getStatusCode()]);
        }

        if ($e instanceof \Illuminate\Auth\AuthenticationException) {
            if ($request->expectsJson())
                return response()->json(['error' => 'Usuario nao autenticado.', 401]);
        }
        
        return parent::render($request, $e);

    }


}
