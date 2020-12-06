<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Articulo;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArticuloController extends Controller{

    public function listar(Request $request){
        $request->validate([
            'nombre' => '',
            'id' => '',
            'empresa_id' => '',
        ]);
        $articulo = Articulo::query()->with(['miniatura','empresa']);
        if($nombre = $request->get('nombre')){
            $articulo->where('nombre','like','%'.$nombre.'%');
        }
        if($id = $request->get('id')){
            $articulo->where('id',$id);
        }
        if($empresa_id = $request->get('empresa_id')){
            $articulo->whereHas('empresa',function(Builder $q) use ($empresa_id) {
                $q->whereId($empresa_id);
            });
        }
        $articulo->orderBy('nombre');
        return paginate($articulo,$request);
    }

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
        return $this->update($request,$empresa,Articulo::constructorCrear()->constructorCrearEmpresa($empresa));
    }

    public function update(Request $request, Empresa $empresa, Articulo $articulo){
        $validatedData = $request->validate([
            'photo' => 'image|dimensions:min_width=100,min_height=100,max_width=500,max_height=500',
            'nombre' => '',
            'descripcion' => '',
            'precio' => ''
        ]);
        if($articulo->empresa_id != $empresa->id){
            return response(['message' => 'No permitido, empresa ajena'],401);
        }else{
            if($photo = $request->file('photo')){
                $archivo = Archivo::crearAleatorio('jpg');
                Storage::disk('s3')->put($archivo->path,$photo->get());
                $articulo->constructorCrearMiniatura($archivo);
            }
            $articulo->constructorCrearNombre($request->get('nombre',''));
            $articulo->constructorDescripcion( $request->get('descripcion',''));
            $articulo->constructorCrearPrecio($request->get('precio',0));
            $articulo->constructorGuardar();
            return $articulo;
        }
    }
}
