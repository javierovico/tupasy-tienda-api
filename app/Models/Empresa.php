<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Empresa
 * @package App\Models
 * @property mixed id
 * @property mixed nombre
 * @property mixed miniatura_id
 * @property mixed logo_id
 * @property mixed created_at
 * @property mixed updated_at
 * @method static self find($empresaID)
 * @method static self first()
 */
class Empresa extends Model
{
    use HasFactory;

    public function articulos(){
        return $this->hasMany(Articulo::class,'empresa_id','id');
    }

    public static function constructorCrear():self {
        return new self();
    }

    public function constructorCrearId($id): self{
        $this->id = $id;
        return $this;
    }
    public function constructorCrearNombre($nombre): self{
        $this->nombre = $nombre;
        return $this;
    }
    public function constructorCrearMiniatura_id($miniatura_id): self{
        $this->miniatura_id = $miniatura_id;
        return $this;
    }
    public function constructorCrearLogo_id($logo_id): self{
        $this->logo_id = $logo_id;
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

    public function constructorGuardar() : self {
        $this->save();
        return $this;
    }

}
