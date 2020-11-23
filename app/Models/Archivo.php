<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @method static self firstOrCreate(array $array)
 * @property mixed tipo
 * @property mixed path
 * @property string url
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
    protected $fillable = ['path','tipo'];

    const TIPO_DEFECTO = self::TIPO_ARCHIVO;

    public static function crearAleatorio(string $extension = '', $tipo = self::TIPO_DEFECTO) : self{
        for($intentos = 100; $intentos >=0 ; $intentos++){
            $nombreArchivo = Str::random(50) . '.'.$extension;
            if(null == (self::query()->where('path', $nombreArchivo)->where('tipo' , $tipo)->first())){
                return self::encontrarOCrear($nombreArchivo,$tipo);
            }
        }
        throw new \Exception('mas de 100 intentos');
    }


    public function getUrlAttribute(){
        return str_replace('%%',$this->path,self::INDICE_URL[$this->tipo]);
    }


    public static function encontrarOCrear($path, $tipo) : self{
        return self::firstOrCreate(['path' => $path,'tipo'=>$tipo]);
    }
}
