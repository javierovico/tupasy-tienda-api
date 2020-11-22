<?php

namespace App\Http\Middleware;

use App\Models\Empresa;
use App\Models\Permiso;
use App\Models\Rol;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EmpresaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $permisoCode
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permisoCode){
        /** @var Empresa $empresa */
        $empresa = $request->route('empresa');
        /** @var User $user */
        $user = $request->user();
        $permiso = Permiso::findByCode($permisoCode);
        if($user->comprobarPermisoEmpresa($permiso,$empresa)){
            return $next($request);
        }else{
            return response(['message' => 'Sin permiso'],401);
        }
//
    }
}
