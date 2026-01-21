<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('courses')->delete();
        
        DB::table('courses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Engenharia Informática',
                'description' => NULL,
                'created_at' => '2026-01-20 13:43:01',
                'updated_at' => '2026-01-20 13:43:01',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Engenharia de Telecom',
                'description' => NULL,
                'created_at' => '2026-01-20 13:43:21',
                'updated_at' => '2026-01-20 13:43:21',
            ),
        ));
        
        
    }
}