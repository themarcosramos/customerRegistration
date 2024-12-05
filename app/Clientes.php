<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $fillable = [
        'id',
        'tipo_clientes_id',
        'nome_razaoSocial',
        'sobrenome_nomeFantasia',
        'cnpj_cpf',
        'rg_inscricaoEstadual',
        'inscricao_municipal',
        'status',
        'observacao',
    ];

    public function enderecos()
    {
        return $this->hasMany(Enderecos::class, "clientes_id", "id");
    }

    public function contatos()
    {
        return $this->hasMany(Contatos::class, "clientes_id", "id");
    }
}

