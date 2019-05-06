<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conteudo extends Model
{
    protected $fillable = [
        'titulo','tipo','nome','utilizador','categoria','tag'
    ];
}
