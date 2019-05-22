<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conteudo extends Model
{
    protected $fillable = [
        'titulo','tipo','nome','utilizador','categoria','tag'
    ];

    public function user(){
        return $this->belongsTo("\App\User");
    }
    public function Category(){
        return $this->hasMany("\App\Categoria");
    }
}
