<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enderecos extends Model
{
    protected $fillable = [
        'clientes_id',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'cep',
        'status',
        'observacao'
    ];
}
