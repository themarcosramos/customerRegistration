<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContatos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('clientes_id')->unsigned();
            $table->integer('contato_tipos_id')->nullable()->unsigned();
            $table->string('nome', 150);
            $table->string('email', 100);
            $table->string('telefone1', 20);
            $table->string('telefone2', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->text('observacao')->nullable();
            $table->char('status',1)->default(1);
            $table->foreign('contato_tipos_id')->references('id')->on('contato_tipos');
            $table->foreign('clientes_id')->references('id')->on('clientes');
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
        Schema::dropIfExists('contatos');
    }
}
