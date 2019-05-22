<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conteudo extends Model
{
    protected $fillable = [
        'titulo','tipo','nome','descricao','privado','user_id'
    ];

    public function user(){
        return $this->belongsTo("\App\User");
    }
    public function Category(){
        return $this->hasMany("\App\Categoria");
    }
}
