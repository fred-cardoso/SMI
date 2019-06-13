<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ConteudoUserTrait;

class Conteudo extends Model
{
    use ConteudoUserTrait;

    protected $fillable = [
        'titulo','tipo','nome','descricao','privado','user_id'
    ];

    public function category(){
        return $this->belongsToMany(Categoria::class, "conteudos_categorias");
    }

    public function hasCategory(... $categories){
        foreach ($categories as $category) {
            if ($this->category()->where('id', $category->id)->exists()) {
                return true;
            }
        }
        return false;
    }
}
