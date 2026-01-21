<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('departments')->delete();
        
        DB::table('departments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'DMICD',
                'description' => 'Departamento de desenvolvimento',
                'department_head_name' => NULL,
                'head_photo' => NULL,
                'created_at' => '2026-01-20 13:37:15',
                'updated_at' => '2026-01-20 13:37:15',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Infra',
                'description' => 'Departamento de infraestrutura',
                'department_head_name' => NULL,
                'head_photo' => NULL,
                'created_at' => '2026-01-20 13:37:33',
                'updated_at' => '2026-01-20 13:37:33',
            ),
        ));
        
        
    }
}