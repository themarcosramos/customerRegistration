<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contatos extends Model
{
    protected $fillable = [
        'clientes_id',
        'contato_tipos_id',
        'nome',
        'email',
        'telefone1',
        'telefone2',
        'celular',
        'status',
        'observacao'
    ];
}
