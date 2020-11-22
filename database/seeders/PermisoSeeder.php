<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        foreach(Permiso::PERMISOS_ARRAY as $permisoCodigo => $estadoDummy){
            Permiso::constructorCrear()
                ->constructorCrearCodigo($permisoCodigo)
                ->constructorGuardar();
        }
    }
}
