<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tipo_clientes_id')->unsigned();
            $table->string('nome_razaoSocial',150);
            $table->string('sobrenome_nomeFantasia',150);
            $table->string('cnpj_cpf',50);
            $table->string('rg_inscricaoEstadual',50)->nullable();
            $table->string('inscricao_municipal',50)->nullable();
            $table->char('status',1)->default(1);
            $table->text('observacao')->nullable();
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
        Schema::dropIfExists('clientes');
    }
}
