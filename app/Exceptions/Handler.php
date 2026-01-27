<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        // Manejar error 404 - Página no encontrada
        if ($exception instanceof NotFoundHttpException) {
            return redirect()
                ->route('error')
                ->with('error', '❌ Error 404: La página que buscas no existe.');
        }

        // Manejar error 403 - Acceso denegado
        if ($exception instanceof HttpException && $exception->getStatusCode() == 403) {
            return redirect()
                ->route('error')
                ->with('error', '❌ Error 403: No tienes permiso para acceder a esta página.');
        }

        // Manejar error 500 - Error del servidor
        if ($exception instanceof HttpException && $exception->getStatusCode() == 500) {
            return redirect()
                ->route('error')
                ->with('error', '❌ Error 500: Error interno del servidor. Por favor intenta más tarde.');
        }

        // Manejar error 503 - Servicio no disponible
        if ($exception instanceof HttpException && $exception->getStatusCode() == 503) {
            return redirect()
                ->route('error')
                ->with('error', '❌ Error 503: Servicio temporalmente no disponible. Estamos en mantenimiento.');
        }

        // Para otros errores, usar el manejador por defecto
        return parent::render($request, $exception);
    }
}