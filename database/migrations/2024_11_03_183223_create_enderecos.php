<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('clientes_id')->unsigned();
            $table->string('logradouro', 150);
            $table->string('numero', 10);
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 50);
            $table->string('cidade', 50);
            $table->char('uf', 2);
            $table->string('cep', 10);
            $table->text('observacao')->nullable();
            $table->char('status',1)->default(1);
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
        Schema::dropIfExists('enderecos');
    }
}
