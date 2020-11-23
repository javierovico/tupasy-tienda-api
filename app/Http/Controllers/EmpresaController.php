<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;

class EmpresaController extends Controller{

    public function index(Request $request){
        /** @var User $user */
        $user = $request->user();
        $query = $user->empresas();
        return paginate($query,$request);
    }

    public function show(Request $request, Empresa $empresa){
        /** @var User $user */
        return ['data'=>$empresa];
    }

    public function create(Request $request){
        $request->validate([
            'nombre' => 'required',
        ]);
        /** @var User $admin */
        $admin = $request->user();
        $empresa = Empresa::constructorCrear()
            ->constructorCrearNombre($request->get('nombre'))
            ->constructorGuardar()
        ;
        $rolAdmin = Rol::findByCode(Rol::ROL_CODIGO_ADMIN); //luego ver un rol basico TODO
        $admin->agregarPermiso($empresa,$rolAdmin);
    }
}
