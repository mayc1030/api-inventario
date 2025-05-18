<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/**
 * Clase Handler
 *
 * Esta clase centraliza el manejo de excepciones y errores en la aplicación.
 * Se personaliza el comportamiento para que las respuestas sean claras
 * y adaptadas a una API RESTful en formato JSON.
 */
class Handler extends ExceptionHandler
{
    // Campos sensibles que no se deben mostrar en los errores de validación
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registro de excepciones que pueden ser reportadas.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Personalización de respuestas de error según el tipo de excepción
     * para que la API devuelva mensajes claros y códigos de estado HTTP adecuados.
     */
    public function render($request, Throwable $exception)
    {
        // Si el usuario no está autenticado (no ha iniciado sesión)
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'message' => 'No autenticado. Por favor inicia sesión.'
            ], 401);
        }

        // Si el usuario no tiene permiso para la acción solicitada
        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'message' => 'No tienes permiso para realizar esta acción.'
            ], 403);
        }

        // Si la ruta o recurso no existe
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'message' => 'Recurso no encontrado.'
            ], 404);
        }

        // Si se usa un método HTTP inválido en una ruta válida
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json([
                'message' => 'Método HTTP no permitido para esta ruta.'
            ], 405);
        }

        // Si ocurre cualquier otro error interno del servidor
        return response()->json([
            'message' => 'Error interno del servidor.',
            // Mostrar el mensaje de error solo en modo debug
            'error' => config('app.debug') ? $exception->getMessage() : ''
        ], 500);
    }
}
