<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permiso
 * @package App\Models
 * @property mixed id
 * @property mixed codigo
 * @property mixed descripcion
 * @property mixed created_at
 * @property mixed updated_at
 */
class Permiso extends Model{
    use HasFactory;

    public const PERMISO_CODIGO_CREAR_PRODUCTO = 'crear_prod';
    public const PERMISO_CODIGO_BORRAR_PRODUCTO = 'borrar_prod';
    public const PERMISO_CODIGO_VER_EMPRESA = 'ver_empresa';
    const PERMISO_CODIGO_VER_ARTICULOS = 'ver_articulos';

    public const PERMISOS_ARRAY = [
        self::PERMISO_CODIGO_CREAR_PRODUCTO => true,
        self::PERMISO_CODIGO_BORRAR_PRODUCTO => true,
        self::PERMISO_CODIGO_VER_EMPRESA => true,
        self::PERMISO_CODIGO_VER_ARTICULOS => true,
        self::PERMISO_VER_ARTICULO => true,
        self::PERMISO_CODIGO_CREAR_ARTICULO => true,
        self::PERMISO_EDITAR_ARTICULO => true,
        self::PERMISO_GLOBAL_AGREGAR_EMPRESA => true,
    ];
    const PERMISO_VER_ARTICULO = 'ver_articulo';
    const PERMISO_CODIGO_CREAR_ARTICULO = 'crear_articulo';
    const PERMISO_EDITAR_ARTICULO = 'editar_articulo';
    const PERMISO_GLOBAL_AGREGAR_EMPRESA = 'global_agregar_empresa';


    public static function constructorCrear():self{
        return new self();
    }

    /**
     * @param string $permisoCodigo
     * @return self
     */
    public static function findByCode(string $permisoCodigo){
        return self::query()->where('codigo',$permisoCodigo)->first();
    }

    public function constructorCrearId($id): self{
        $this->id = $id;
        return $this;
    }

    public function constructorCrearCodigo($codigo): self{
        $this->codigo = $codigo;
        return $this;
    }

    public function constructorCrearDescripcion($descripcion): self{
        $this->descripcion = $descripcion;
        return $this;
    }

    public function constructorCrearCreated_at($created_at): self{
        $this->created_at = $created_at;
        return $this;
    }

    public function constructorCrearUpdated_at($updated_at): self{
        $this->updated_at = $updated_at;
        return $this;
    }

    public function constructorGuardar(){
        $this->save();
        return $this;
    }
}
