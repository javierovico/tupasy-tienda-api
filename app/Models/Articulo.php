<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Articulo
 * @package App\Models
 * @property mixed id
 * @property mixed nombre
 * @property mixed precio
 * @property mixed miniatura_id
 * @property mixed empresa_id
 * @property mixed created_at
 * @property mixed updated_at
 * @property Archivo miniatura
 * @property string descripcion
 */
class Articulo extends Model{
    use HasFactory;

    protected $appends = ['urlWhatsapp'];

    public function getUrlWhatsappAttribute(){
        return 'https://wa.me/595985118466?text=Estoy interesado en este producto: '.'http://tienda.tupasyrape.com?id='.$this->id;
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function miniatura(){
        return $this->belongsTo(Archivo::class);
    }

    public static function constructorCrear() : self{
        return  new self();
    }

    public function constructorCrearNombre($nombre) : self {
        $this->nombre = $nombre;
        return $this;
    }

    public function constructorCrearPrecio($precio) : self {
        $this->precio = $precio;
        return $this;
    }

    public function constructorCrearMiniatura_id($miniatura_id) : self {
        $this->miniatura_id = $miniatura_id;
        return $this;
    }

    public function constructorCrearEmpresa_id($empresa_id) : self {
        $this->empresa_id = $empresa_id;
        return $this;
    }

    public function constructorCrearCreated_at($created_at) : self {
        $this->created_at = $created_at;
        return $this;
    }

    public function constructorCrearUpdated_at($updated_at) : self {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function constructorGuardar() : self {
        $this->save();
        return $this;
    }

    public function constructorCrearEmpresa(Empresa $empresa) :self{
        $this->empresa()->associate($empresa);
        return $this;
    }

    public function constructorCrearMiniatura(Archivo $archivoMiniatura) : self{
        $this->miniatura()->associate($archivoMiniatura);
        return $this;
    }

    public function constructorDescripcion($descripcion): self{
        $this->descripcion = $descripcion;
        return $this;
    }

}
