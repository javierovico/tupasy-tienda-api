<?php

namespace App\Http\Middleware;

use App\Models\Permiso;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class PermisoGlobalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param $permisoCode
     * @return mixed
     */
    public function handle(Request $request, Closure $next,$permisoCode){
        /** @var User $user */
        $user = $request->user();
        $permiso = Permiso::findByCode($permisoCode);
        if($user->comprobarPermisoGlobal($permiso)){
            return $next($request);
        }else{
            return response(['message' => 'Sin permiso'],401);
        }
    }
}
