<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tag = new Tag();
        $tag->nome="javascript";
        $tag->save();

        $tag = new Tag();
        $tag->nome="cão";
        $tag->save();

        $tag = new Tag();
        $tag->nome="Morais";
        $tag->save();

        $tag = new Tag();
        $tag->nome="CS_GO";
        $tag->save();
    }
}
