<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('specialties')->delete();
        
        DB::table('specialties')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Base de dados',
                'description' => NULL,
                'created_at' => '2026-01-20 13:38:37',
                'updated_at' => '2026-01-20 13:38:37',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Frontend',
                'description' => NULL,
                'created_at' => '2026-01-20 13:38:51',
                'updated_at' => '2026-01-20 13:38:51',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'CCTV',
                'description' => NULL,
                'created_at' => '2026-01-20 13:39:01',
                'updated_at' => '2026-01-20 13:39:01',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Backend',
                'description' => NULL,
                'created_at' => '2026-01-20 13:39:13',
                'updated_at' => '2026-01-20 13:39:13',
            ),
        ));
        
        
    }
}