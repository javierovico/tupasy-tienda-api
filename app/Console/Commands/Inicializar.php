<?php

namespace App\Console\Commands;

use App\Models\Empresa;
use App\Models\Permiso;
use App\Models\Rol;
use App\Models\User;
use Database\Seeders\PermisoSeeder;
use Database\Seeders\RolSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Inicializar extends Command{

    protected $signature = 'inicializar';

    protected $description = 'Borra todo lo que hay e inicializa';


    public function __construct(){
        parent::__construct();
    }


    public function handle(){
        Artisan::call('migrate:fresh');
        Artisan::call('migrate:refresh');
        Artisan::call('migrate');
        Artisan::call('passport:install');
        Artisan::call('db:seed --class=PermisoSeeder');
        Artisan::call('db:seed --class=RolSeeder');
        $empresa = Empresa::constructorCrear()
            ->constructorCrearNombre('Empanadas Francisco')
            ->constructorGuardar()
        ;
        $admin = User::constructorCrear()
            ->constructorCrearNombre('Aldo Javier')
            ->constructorCrearApellido('Ibarra Gonzalez')
            ->constructorCrearEmail('javierovico@gmail.com')
            ->constructorCrearPassword('adm1n')
            ->constructorGuardar();
        $admin = User::constructorCrear()
            ->constructorCrearNombre('Luis')
            ->constructorCrearApellido('Martinez')
            ->constructorCrearEmail('luis@tupasyrape.com')
            ->constructorCrearPassword('lu1s')
            ->constructorGuardar();
        $rolAdmin = Rol::findByCode(Rol::ROL_CODIGO_ADMIN);
        $admin->agregarPermiso($empresa,$rolAdmin);
        $rolAdminGeneral = Rol::findByCode(Rol::ROL_CODIGO_ADMIN_GENERAL);
        $admin->agregarPermisoGeneral($rolAdminGeneral);
        return 0;
    }
}
