<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Verifica si el usuario autenticado tiene el rol de administrador.
     *
     * Este middleware intercepta la solicitud y comprueba si el usuario autenticado
     * tiene asignado el rol "admin". Si no es así, se retorna una respuesta JSON
     * con error 403 (No autorizado).
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud entrante HTTP.
     * @param  \Closure  $next  El siguiente middleware o controlador a ejecutar.
     * @return \Symfony\Component\HttpFoundation\Response  La respuesta HTTP resultante.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'No autorizado.'], 403);
        }
        return $next($request);
    }
}
