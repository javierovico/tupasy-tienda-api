<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Empresa;
use Illuminate\Http\Request;

class ArticuloController extends Controller{

    public function index(Request $request, $empresa_id){
        $empresa = Empresa::find($empresa_id);
        $query = $empresa->articulos()->with('miniatura');
        return paginate($query,$request);
    }

    public function show(Request $request, Empresa $empresa, Articulo $articulo){
        if($articulo->empresa_id != $empresa->id){
            return response(['message' => 'No permitido, empresa ajena'],401);
        }else{
            return ['data' => $articulo->load('miniatura')];
        }
    }

    public function create(Request $request, Empresa $empresa){
        return $empresa;
    }

    public function update(Request $request, Empresa $empresa, Articulo $articulo){
        $validatedData = $request->validate([
            'photo' => 'mimes:jpeg|dimensions:min_width=100,min_height=100,max_width=500,max_height=500',
        ]);
        if($articulo->empresa_id != $empresa->id){
            return response(['message' => 'No permitido, empresa ajena'],401);
        }else{
            if($photo = $request->file('photo')){

                $archivo = $articulo->miniatura;
            }
            return $request->all();
        }
    }
}
