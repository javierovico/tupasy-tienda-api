<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static self firstOrCreate(array $array)
 * @property mixed tipo
 * @property mixed path
 */
class Archivo extends Model
{
    use HasFactory;

    public const TIPO_ARCHIVO = 1;
    public const TIPO_ABSOLUTO = 2;
    public const INDICE_URL = [
        self::TIPO_ABSOLUTO => '%%',
        self::TIPO_ARCHIVO => 'https://tupasy-tienda.s3.us-east-2.amazonaws.com/archivos/%%',
    ];

    protected $appends = ['url'];

    const TIPO_DEFECTO = 1;


    public function getUrlAttribute(){
        return str_replace('%%',$this->path,self::INDICE_URL[$this->tipo]);
    }


    public static function encontrarOCrear($path, $tipo) : self{
        return self::firstOrCreate(['path' => $path,'tipo'=>$tipo]);
    }
}
