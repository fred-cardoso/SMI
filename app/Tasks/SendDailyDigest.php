<?php

namespace App\Tasks;

use App\Mail\DailyDigest;
use Carbon\Carbon;
use \App\Conteudo;
use \App\User;
use Illuminate\Support\Facades\Mail;

class SendDailyDigest
{
    public function __invoke()
    {
        $conteudos = Conteudo::where([['created_at', '>', Carbon::now()->subDays(1)->toDateTimeString()],['privado', '=', '0']])->get();

        if(sizeof($conteudos) <= 0) {
            dd("Sem conteúdos");
            return;
        }

        $utilizadores = User::all();

        foreach($utilizadores as $utilizador) {
            $user_categorias = $utilizador->categoria()->get();

            $conteudos_for_user = array();

            foreach ($conteudos as $conteudo) {
                foreach($user_categorias as $categoria) {
                    if($conteudo->hasCategory($categoria)) {
                        array_push($conteudos_for_user, $conteudo);
                        break 2;
                    }
                }
            }

            Mail::to($utilizador)->send(new DailyDigest($conteudos_for_user));
        }
    }
}