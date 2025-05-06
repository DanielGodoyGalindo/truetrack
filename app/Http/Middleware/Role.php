<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * 
     * Controla un request recibido.
     * 
     * La función recibe como parámetros un http Request, una Closure que sirve para la representación de funciones anónimas y un array de roles de usuario
     * Si el usuario no está autenticado lo redirige al index y si el rol del usuario autenticado no se encuentra en el array de roles le muestra una pantalla 403
     * y aborta el request denegando el acceso al usuario
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {

        if (!Auth::check()) {
            return redirect()->route('index');
        }

        if (!in_array(Auth::user()->rol, $roles)) {
            abort(403, "No tienes permiso para acceder");
        }

        return $next($request);
    }
}
