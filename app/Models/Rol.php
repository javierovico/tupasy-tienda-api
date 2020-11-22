<?php

namespace App\Models;

use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rol
 * @package App\Models
 * @property mixed id
 * @property mixed codigo
 * @property mixed nombre
 * @property mixed created_at
 * @property mixed updated_at
 */
class Rol extends Model{
    use HasFactory;
    use EagerLoadPivotTrait;

    public const ROL_CODIGO_ADMIN = 'admin';

    public const ROLES_ARRAY = [
        self::ROL_CODIGO_ADMIN=>[
            Permiso::PERMISO_CODIGO_CREAR_PRODUCTO => true,
            Permiso::PERMISO_CODIGO_BORRAR_PRODUCTO => true,
            Permiso::PERMISO_CODIGO_VER_EMPRESA => true,
            Permiso::PERMISO_CODIGO_VER_ARTICULOS => true,
            Permiso::PERMISO_VER_ARTICULO => true,
            Permiso::PERMISO_CODIGO_CREAR_ARTICULO => true,
            Permiso::PERMISO_EDITAR_ARTICULO => true,
        ],
    ];

    /**
     * @param string $codigo
     * @return self
     */
    public static function findByCode(string $codigo){
        return self::where('codigo',$codigo)->first();
    }

    public function permisos(){
        return $this->belongsToMany(Permiso::class,'rol_permiso');
    }

    public static function constructorCrear():self{
        return new self();
    }

    public function constructorCrearCodigo($codigo): self{
        $this->codigo = $codigo;
        return $this;
    }

    public function constructorCrearNombre($nombre): self{
        $this->nombre = $nombre;
        return $this;
    }

    public function constructorGuardar() :self {
        $this->save();
        return $this;
    }

    public function agregarPermiso(Permiso $permiso){
        $this->permisos()->attach($permiso);
    }
}
