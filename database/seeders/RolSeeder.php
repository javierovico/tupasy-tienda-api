<?php

namespace Database\Seeders;

use App\Models\Permiso;
use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder{

    public function run(){

        foreach(Rol::ROLES_ARRAY as $rolCodigo => $permisos){
            $rol = Rol::constructorCrear()
                ->constructorCrearCodigo($rolCodigo)
                ->constructorCrearNombre($rolCodigo)
                ->constructorGuardar();
            foreach($permisos as $permisoCodigo=>$dummy){
                $permiso = Permiso::findByCode($permisoCodigo);
                $rol->agregarPermiso($permiso);
            }
        }
    }
}
