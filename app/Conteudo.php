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
    public function category(){
        return $this->belongsToMany(Categoria::class, "conteudos_categorias");
    }

    public function hasCategory($category){
        return $this->category()->where('id', $category->id)->exists();
    }
}
