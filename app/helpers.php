<?php

use App\Delivery\Delivery;
use App\Jedy\ArticuloSP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

function imprimirHola(){
    return 'hola';
}

function paginate($builder,Request $request){
    $request->validate([
        'perPage' => 'integer|min:1|max:1000',
        'page' => 'integer|min:1',
    ]);
    return $builder->paginate($request->get('perPage',10),['*'],'page',$request->get('page',1));
}

function mkstemp( $template ) {
    $attempts = 238328; // 62 x 62 x 62
    $letters  = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $length   = strlen($letters) - 1;

    if( mb_strlen($template) < 6 || !strstr($template, 'XXXXXX') )
        return FALSE;

    for( $count = 0; $count < $attempts; ++$count) {
        $random = "";

        for($p = 0; $p < 6; $p++) {
            $random .= $letters[mt_rand(0, $length)];
        }

        $randomFile = str_replace("XXXXXX", $random, $template);

        if( !($fd = @fopen($randomFile, "x+")) )
            continue;

        return $fd;
    }

    return FALSE;
}

/**
 * @param array $sortedArray
 * @param $searchElement
 * @return bool
 * https://gist.github.com/prabeengiri/462f8f7d6a31523141b9
 */
function binary_search(array $sortedArray, $searchElement) {
    // Check if array is sorted
    $min_index = 0;
    $max_index = count($sortedArray) - 1;
    //echo "Size of the array: " . count($sortedArray). "<br>";
    while ($min_index <= $max_index) {
        // Get the decimal value as bitwise operator operates only on integer value.
        $currentIndex = ($min_index + $max_index ) / 2 | 0;
        $currentElement = $sortedArray[$currentIndex];
        if ($currentElement == $searchElement) {
            return TRUE;
        } else if ($currentElement < $searchElement) {
            $min_index = $currentIndex + 1;
        } else if ($currentElement > $searchElement) {
            $max_index = $currentIndex -1;
        }
    }
    return FALSE;
}

function configJedy($delivery){
    if(is_int($delivery)){
        $delivery = Delivery::getById($delivery);
    }
    $connection = $delivery->jedyConection;
    Config::set("database.connections.jedysoft", [
        "driver" => 'firebird',
        "host" => $connection->host,
        "database" => $connection->database,
        "username" => $connection->username,
        "password" => $connection->password,
//        'charset' => 'wchar',
        'charset' => 'utf8',
//        'collation' => 'utf8_unicode_ci',
        'role' => null,
        'port' => $connection->port
    ]);
    ArticuloSP::$clienteId = $delivery->idDelivery;
}
