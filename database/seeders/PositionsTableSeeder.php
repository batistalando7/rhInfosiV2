<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('positions')->delete();
        
        DB::table('positions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Desenvolvedor',
                'description' => NULL,
                'created_at' => '2026-01-20 13:37:47',
                'updated_at' => '2026-01-20 13:37:47',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Gestor de projetos',
                'description' => NULL,
                'created_at' => '2026-01-20 13:37:59',
                'updated_at' => '2026-01-20 13:37:59',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Técnico de infraestrutura',
                'description' => NULL,
                'created_at' => '2026-01-20 13:38:21',
                'updated_at' => '2026-01-20 13:38:21',
            ),
        ));
        
        
    }
}