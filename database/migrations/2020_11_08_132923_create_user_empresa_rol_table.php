<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEmpresaRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_empresa_rol', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');  //referencia a users
            $table->unsignedBigInteger('empresa_id');   //referencia a empresa
            $table->unsignedBigInteger('rol_id');       //referencia a rol
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_empresa_rol');
    }
}
