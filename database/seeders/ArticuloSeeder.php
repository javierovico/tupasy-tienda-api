<?php

namespace Database\Seeders;

use App\Models\Archivo;
use App\Models\Articulo;
use App\Models\Empresa;
use Illuminate\Database\Seeder;

class ArticuloSeeder extends Seeder{

    public const ARTICULOS_PRUEBA = [
        [
            'nombre' => 'Ao po\'i',
            'precio' => 20000,
            'miniatura' => [
                'path' => 'cantaro.jpg',
                'tipo' => Archivo::TIPO_DEFECTO
            ]
        ],
        [
            'nombre' => 'Cantaro',
            'precio' => 150000,
            'miniatura' => [
                'path' => 'cantaro.jpg',
                'tipo' => Archivo::TIPO_DEFECTO
            ]
        ],
        [
            'nombre' => 'Pinda',
            'precio' => 15000,
            'miniatura' => [
                'path' => 'cantaro.jpg',
                'tipo' => Archivo::TIPO_DEFECTO
            ]
        ],
        [
            'nombre' => 'Vaso',
            'precio' => 1500,
            'miniatura' => [
                'path' => 'cantaro.jpg',
                'tipo' => Archivo::TIPO_DEFECTO
            ]
        ]
    ];

    public function run(){
        $empresa = Empresa::first();    //hardcodeado feo
        foreach(self::ARTICULOS_PRUEBA as $articulo){
            $archivoMiniatura = Archivo::encontrarOCrear($articulo['miniatura']['path'],$articulo['miniatura']['tipo']);
            $articulo = Articulo::constructorCrear()
                ->constructorCrearNombre($articulo['nombre'])
                ->constructorCrearPrecio($articulo['precio'])
                ->constructorCrearEmpresa($empresa)
                ->constructorCrearMiniatura($archivoMiniatura)
                ->constructorGuardar()
            ;
        }
    }
}
