<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
 * Clase Kernel
 *
 * Esta clase es el núcleo del manejo de middleware HTTP en la aplicación Laravel.
 *
 * Importante:
 * - Define los middleware globales que se ejecutan en cada petición HTTP.
 * - Organiza middleware en grupos para rutas 'web' y 'api'.
 * - Define aliases para middleware para poder asignarlos fácilmente en rutas y controladores.
 */
class Kernel extends HttpKernel
{
    /**
     * Middleware globales de la aplicación.
     *
     * Estos middleware se ejecutan en **cada** solicitud HTTP que llegue a la aplicación,
     * independientemente de la ruta.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class, // Middleware para confianza en hosts
        \App\Http\Middleware\TrustProxies::class, // Maneja proxies confiables y encabezados
        \Illuminate\Http\Middleware\HandleCors::class, // Controla políticas CORS
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class, // Bloquea peticiones si la app está en mantenimiento
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, // Valida el tamaño de las peticiones POST
        \App\Http\Middleware\TrimStrings::class, // Recorta espacios en blanco en los inputs
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, // Convierte strings vacíos a null
    ];

    /**
     * Grupos de middleware para rutas específicas.
     *
     * Facilita asignar varios middleware a rutas que comparten características comunes.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class, // Encripta cookies
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, // Añade cookies a la respuesta
            \Illuminate\Session\Middleware\StartSession::class, // Inicia sesión HTTP
            \Illuminate\View\Middleware\ShareErrorsFromSession::class, // Comparte errores de validación con las vistas
            \App\Http\Middleware\VerifyCsrfToken::class, // Protege contra ataques CSRF
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Sustituye bindings de rutas por modelos
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Controla solicitudes stateful(Cuando una aplicación recuerda el estado o sesión del usuario entre varias peticiones, generalmente usando cookies.Es decir, el servidor mantiene información sobre el usuario mientras navega, sin pedir autenticación en cada solicitud.) en frontend para Sanctum
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api', // Limita la tasa de peticiones para evitar abuso
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Bindings de rutas para APIs
        ],
    ];

    /**
     * Alias para middleware.
     *
     * Permiten asignar middleware en rutas usando nombres cortos en lugar de clases completas,
     * facilitando su uso y legibilidad.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'auth' => \App\Http\Middleware\Authenticate::class, // Autenticación de usuarios
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, // Autenticación HTTP básica
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class, // Autenticación con sesión activa
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class, // Control de cache HTTP
        'can' => \Illuminate\Auth\Middleware\Authorize::class, // Autorización basada en permisos
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class, // Redirige usuarios autenticados
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class, // Solicita confirmación de contraseña
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class, // Maneja peticiones anticipadas
        'signed' => \App\Http\Middleware\ValidateSignature::class, // Valida firmas en URLs
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // Limitador de tasa de peticiones
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Verifica email confirmado
        'isAdmin' => \App\Http\Middleware\IsAdmin::class, // Middleware personalizado para verificar rol admin
    ];
}
