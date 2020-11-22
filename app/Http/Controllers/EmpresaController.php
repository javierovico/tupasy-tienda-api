<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
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
}
