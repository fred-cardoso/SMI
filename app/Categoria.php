<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'secundaria',
    ];
    public function subscribeUser(){
        return $this->belongsTo("\App\User");
    }
    public function content(){
        return $this->belongsToMany(Conteudo::class, "conteudos_categorias");
    }
}
