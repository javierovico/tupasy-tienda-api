<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserEmpresaRol extends Pivot{

    protected $with = ['empresa'];

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }
}
